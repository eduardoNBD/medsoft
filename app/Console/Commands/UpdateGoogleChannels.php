<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Doctor;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Log;

class UpdateGoogleChannels extends Command
{ 
    protected $signature = 'google:refresh-channels';
    protected $description = 'Update Channels from doctors';
 
    public function handle()
    {
        $doctors = Doctor::whereNotNull('google_access_token')->get();

        foreach ($doctors as $doctor) {
            try { 
                $client = new Google_Client();
                $client->setApplicationName('unidadmedicavph'); 
                $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
                $client->setAccessToken($doctor->google_access_token);
            
                if ($client->isAccessTokenExpired()) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($doctor->google_refresh_token);
                    $doctor->google_access_token = $newToken['access_token'];
                    $doctor->save();
                }
 
                $service = new Google_Service_Calendar($client); 
                $channel = new \Google_Service_Calendar_Channel([
                    'id' => uniqid(),   
                    'type' => 'web_hook',
                    'address' => config('app.url').'/google/webhook', 
                    'params' => [
                        'ttl' => 86400, 
                    ],
                ]);

                $watch = $service->events->watch('primary', $channel); 
                
                $doctor->channel_id = $watch->getId();
                $doctor->save();

                Log::info("Canal actualizado para el doctor: {$doctor->id}");
            } catch (\Exception $e) {
                Log::error("Error al actualizar el canal para el doctor {$doctor->id}: " . $e->getMessage());
            }
        }
    }
}
