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
    User,
    MedicalUnit,
    CertificateRequest
}; 

class SendRequestCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $certificateRequest;
    /**
     * Create a new job instance.
     * @param CertificateRequest $certificateRequest
     */
    public function __construct(CertificateRequest $certificateRequest)
    {
        $this->certificateRequest = $certificateRequest;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { 
        $logos = Setting::select(['value'])->where("key","logos")->first();
        $logos = $logos ? json_decode($logos->value) : json_decode('{"logo_light":"", "logo_dark":""}');
        
        $imagePath = $logos->logo_dark 
        ? public_path("../resources/img/brand/").$logos->logo_dark 
        : public_path('../resources/img/brand/logo_white.svg');
    
        $imageData = File::get($imagePath); 
        $mimeType = mime_content_type($imagePath); 
        $base64 = base64_encode($imageData); 
        
        $patient = User::find($this->certificateRequest->patient->user_id);
        $user = User::find($this->certificateRequest->doctor->user_id);
        $types = [
            "1" => __("messages.medicalCertificate"),
            "2" => __("messages.certificate"),
            "3" => __("messages.recipe")
        ];

        Mail::send("emails.".$user->language.".newRequest", [
                'patientFullname' => $patient->first_name." ".$patient->last_name, 
                'notes' => $this->certificateRequest->notes, 
                'type' => $types[$this->certificateRequest->type], 
                'doctorFullname' => $user->first_name." ".$user->last_name, 
                'logoBase64' => 'data:' . $mimeType . ';base64,' . $base64
            ], 
            function ($message) use ($user){
                $message->to($user->email);
                $message->subject("Nueva Solicitud");
            }
        ); 
    }
}
