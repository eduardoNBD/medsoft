<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   
use App\Models\{ 
    User,
}; 
use App\Notifications\UserNotification; 
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;

class NotificationsController extends Controller
{ 
    public function markAsRead(Request $request, $id){  
        $notification = DatabaseNotification::findOrFail($id); 
        $notification->markAsRead();
        return redirect(config('app.url').$notification['data']['url']); 
    }

    public function list(Request $request){ 
        $user = auth()->user(); 
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->limit(5)->get();

        $notifications = $notifications->map(function($notification) {
            $data = $notification->data; 
            $data['title'] = __($data['title']);

            if(isset($notification->data['messageParams']['appointmentMonth'])){
                $data['messageParams']['appointmentMonth'] = __($notification->data['messageParams']['appointmentMonth']);
            }

            if(isset($notification->data['messageParams']['typeDocument'])){
                $data['messageParams']['typeDocument'] = __($notification->data['messageParams']['typeDocument']);
            }

            $data['message'] = __($data['messageKey'], $data['messageParams']);

            return [
                'id' => $notification->id,
                'data' => $data,
                'read_at' => $notification->read_at ? Carbon::parse($notification->read_at)->setTimezone(session('timezone'))->toDateTimeString() : null,
                'created_at' => Carbon::parse($notification->created_at)->setTimezone(session('timezone'))->toDateTimeString(),
            ];
        });

        return response()->json(["status" => 1, 'items' => $notifications, 'unread' => $user->unreadNotifications()->count() ]);
    } 

    public function stream(Request $request){
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        while (true) {
            $user = auth()->user(); 
            $notifications = $user->notifications()->orderBy('created_at', 'desc')->limit(5)->get();

            $notifications = $notifications->map(function($notification) {
                $data = $notification->data; 
                $data['title'] = __($data['title']);

                if(isset($notification->data['messageParams']['appointmentMonth'])){
                    $data['messageParams']['appointmentMonth'] = __($notification->data['messageParams']['appointmentMonth']);
                }

                if(isset($notification->data['messageParams']['typeDocument'])){
                    $data['messageParams']['typeDocument'] = __($notification->data['messageParams']['typeDocument']);
                }

                $data['message'] = __($data['messageKey'], $data['messageParams']);

                return [
                    'id' => $notification->id,
                    'data' => $data,
                    'read_at' => $notification->read_at ? Carbon::parse($notification->read_at)->setTimezone(session('timezone'))->toDateTimeString() : null,
                    'created_at' => Carbon::parse($notification->created_at)->setTimezone(session('timezone'))->toDateTimeString(),
                ];
            });
 

            echo "data: " . json_encode([
                'items' => $notifications, 
                'unread' => $user->unreadNotifications()->count()
            ]) . "\n\n";

            ob_flush();
            flush();
            sleep(5); 
        }
    }

    public function delete(Request $request, $id){  
        $notification = DatabaseNotification::findOrFail($id); 
        $notification->delete();

        return response()->json(["status" => 1, "message" => ""]);
    } 
}



