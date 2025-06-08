<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; 
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use App\Models\Encounter;

class GenerateEncounter extends Command
{ 
    protected $signature = 'encounters:autoGenerate';
    protected $description = 'Generate Encounters from appointments from today';
 
    public function handle()
    {
        $today = now()->startOfDay(); 
         
        $appointments = Appointment::whereDate('date', $today)->get();
 
        foreach ($appointments as $appointment) { 
            $encounterExists = Encounter::where('appointment_id', $appointment->id)->exists();

            if (!$encounterExists) {
                $encounter = new Encounter;
                $encounter->appointment_id = $appointment->id;
                $encounter->medical_unit_id= $appointment->medical_unit_id;
                $encounter->patient_id = $appointment->patient_id;
                $encounter->doctor_id = $appointment->doctor_id;
                $encounter->date = $appointment->date;
                $encounter->status = 1;
                $encounter->items = "[]";
                $encounter->diagnosis = "";
                $encounter->subtotal = $appointment->subtotal;      
                $encounter->discount = $appointment->discount;     
                $encounter->subject = $appointment->subject;
                $encounter->addictions = $appointment->addictions;
                $encounter->addictions_text = $appointment->addictions_text;
                $encounter->allergies = $appointment->allergies;
                $encounter->allergies_text = $appointment->allergies_text;
                $encounter->surgeries = $appointment->surgeries;
                $encounter->surgeries_text = $appointment->surgeries_text;
                $encounter->medications = $appointment->medications;
                $encounter->medications_text = $appointment->medications_text;
                $encounter->patient_dob = $appointment->patient_dob;
                $encounter->patient_gender = $appointment->patient_gender;
                $encounter->patient_first_name = $appointment->patient_first_name;
                $encounter->patient_last_name = $appointment->patient_last_name;
                $encounter->patient_email = $appointment->patient_email;
                $encounter->patient_phone = $appointment->patient_phone;
                $encounter->patient_language = $appointment->patient_language;
                $encounter->patient_blood_type = $appointment->patient_blood_type; 
                $encounter->treatment = ""; 
                $encounter->files = "[]"; 
                $encounter->created_by = $appointment->created_by;

                $encounter->save();
 
                Log::info("Encounter created for appointment ID: {$appointment->id}");
            }
        }
    }
}
