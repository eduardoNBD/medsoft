<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment; 
use App\Models\Doctor; 
use Google\Client;
use Google\Service\Calendar;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{ 
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');
        $scope = 'https://www.googleapis.com/auth/calendar';
        $authUrl = "https://accounts.google.com/o/oauth2/auth?"
            . "response_type=code"
            . "&client_id={$clientId}"
            . "&redirect_uri={$redirectUri}"
            . "&scope={$scope}"
            . "&access_type=offline"
            . "&prompt=consent";

        return redirect($authUrl);
    }
 
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code not found'], 400);
        }

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.google.redirect'),
            'grant_type' => 'authorization_code',
        ]);
        
        if ($response->successful()) {
            $tokens = $response->json(); 
            $doctor = auth()->user()->doctor;  
             
            $doctor->google_access_token = $tokens['access_token'];
            $doctor->google_refresh_token = $tokens['refresh_token'];

            $doctor->save();

            if(str_contains(config('app.url'),"https")){
                $this->createWatchChannel($doctor);
            }

            return redirect('/dashboard/profile?msg='.__('messages.accountLinked')."_success");
        }

        return redirect('/dashboard/profile?msg='.__('messages.accountNotLinked')."_error");
    } 
    
    public function createWatchChannel($doctor)
    { 
        $client  = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google_Service_Calendar($client);  
        $channel = new \Google_Service_Calendar_Channel([
            'id' => uniqid(),   
            'type' => 'web_hook',
            'address' => config('app.url').'/google/webhook', 
            'params' => [
                'ttl' => 86400, 
            ],
        ]);
        
        try { 
            $service->events->watch("primary", $channel);

            $doctor->channel_id = $channel->getId();
            $doctor->save();

        } catch (\Exception $e) { 
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    } 

    public function handleWebhook(Request $request){ 
        Log::info('Google Calendar webhook received');  

        $headers = $request->headers->all(); 

        if (!isset($headers['x-goog-channel-id']) || !isset($headers['x-goog-resource-id'])) {
            echo json_encode(["status" => 0, 'message' => 'Invalid Request']);
            exit; 
        }

        $channelId   = $headers['x-goog-channel-id'][0];
        $resourceId  = $headers['x-goog-resource-id'][0];  
        $doctor      = Doctor::where("channel_id", $channelId)->first();
      
        if(!$doctor){
            \Log::error("doctor no found");
            exit;
        }

        $client  = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);

        try { 
            $events = $service->events->listEvents("primary", [
                'timeMin' => date('c'), 
            ]);
    
            foreach ($events->getItems() as $event) { 
                $appointment   = Appointment::where('event_id', $event->getId())->first(); 
                $startDateTime = Carbon::parse($event->getStart()->getDateTime())->toDateTimeString();
                $endDateTime   = Carbon::parse($event->getEnd()->getDateTime())->toDateTimeString();

                if ($appointment) {
                    if ($event->getStatus() === 'cancelled') {
                        $appointment->status = 0;
                        $appointment->updated_at = now();
                        $appointment->save();
                    } else {
                        $appointment->date = $startDateTime;
                        $appointment->end_date = $endDateTime;
                        $appointment->updated_at = now();
                        $appointment->save();
                    } 
                } 
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function initializeGoogleClient($doctor, $scopes) {
        $client = new \Google\Client();
        $client->setApplicationName('unidadmedicavph');
        $client->setScopes($scopes);
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->setAccessToken($doctor->google_access_token);
    
        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($doctor->google_refresh_token);
            $doctor->google_access_token = $newToken['access_token'];
            $doctor->save();
        }
    
        return $client;
    }
}
