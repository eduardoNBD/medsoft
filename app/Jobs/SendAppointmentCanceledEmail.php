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
    Appointment
}; 

class SendAppointmentCanceledEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $appointment;
    /**
     * Create a new job instance.
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
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
        
        $user = User::find($this->appointment->patient->user_id);

        $medicalUnit = MedicalUnit::findOr($this->appointment->medical_unit_id, function () {
            return false;
        });

        Mail::send("emails.".$user->language.".cancelAppointment", [
                'userFullName' => $this->appointment->patient_first_name." ".$this->appointment->patient_last_name, 
                'cancellation_reason' => $this->appointment->cancellation_reason,
                'logoBase64' => 'data:' . $mimeType . ';base64,' . $base64
            ], 
            function ($message) use ($user){
                $message->to($user->email);
                $message->subject("Consulta Cancelada");
            }
        );
    }
}
