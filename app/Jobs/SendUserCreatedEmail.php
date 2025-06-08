<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\{
    Mail,
    File,
    Lang
}; 
use App\Models\{
    Setting,
    User
}; 

class SendUserCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logos = Setting::select(['value'])->where("key","logos")->first();
        $logos = $logos ? json_decode($logos->value) : json_decode('{"logo_light":"", "logo_dark":""}');
        
        $imagePath = $logos->logo_dark 
        ? public_path("../resources/img/brand/").$logos->logo_dark 
        : public_path('../resources/img/brand/logo_white.svg');
    
        $imageData = File::get($imagePath);
        $mimeType = mime_content_type($imagePath);
        $base64 = base64_encode($imageData); 
        $subject = Lang::get('messages.newUser', [], $this->user->language);
        $email = $this->user->email;
        $template = "emails.".$this->user->language.".newUser";
         
        Mail::send($template, [
                'userFullName' => $this->user->first_name." ".$this->user->last_name, 
                'logoBase64' => 'data:' . $mimeType . ';base64,' . $base64
            ], 
            function ($message) { 
                $message->to($this->user->email);
                $message->subject("Nuevo usuario"); 
            }
        );   
    }
}

