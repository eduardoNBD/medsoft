<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Redirect,
    DB,
    Auth,
    File,
    Lang
}; 

use App\Models\{  
    Doctor, 
    Specialty,
    User,
    MedicalHistory,
    Certificate,
    MedicalUnit, 
    Setting,
    Appointment
};

class PublicController extends Controller{
    
    public function index(){ 

        $medicalUnits = MedicalUnit::select([
            "medical_units.id", 
            "medical_units.name", 
            "medical_units.phone",
            "medical_units.email",  
            "medical_units.status", 
            "medical_units.logo",  
            DB::raw("CONCAT(medical_units.address,', ',medical_units.city,', ',medical_units.zipcode,', ',medical_units.country) AS fulladdress"),  
        ])->where("status","!=",0)->get();
         
        return view("public.home",[
            "medicalUnits" => $medicalUnits
        ]);
    }

    public function profile(){   
        $medical_histories = MedicalHistory::where(["patient_id" => Auth::user()->patient->id])->first();
        $certificates = Certificate::select([
                                        "certificates.id",
                                        "certificates.notes",
                                        "certificates.created_at",
                                        "certificates.status", 
                                        DB::raw("CONCAT(doctors.title,' ',doctorUser.first_name,' ',doctorUser.last_name) AS fullnameDoctor"), 
                                    ])
                                    ->leftJoin('medical_units', 'medical_units.id', '=', 'certificates.medical_unit_id')   
                                    ->leftJoin('doctors', 'doctors.id', '=', 'certificates.doctor_id') 
                                    ->leftJoin('users as doctorUser', 'doctorUser.id', '=', 'doctors.user_id')
                                    ->where(["patient_id" => Auth::user()->patient->id])
                                    ->where("expires_at", ">", date("Y-m-d"))->get();
        $appointmentStatus = [
            __('messages.cancel_her'),
            __('messages.pending'),
            __('messages.confirmed'),
            __('messages.completed_her'), 
        ];

        $appointmentStatusColors = [
            'text-red-600',
            'text-gray-600',
            'text-blue-600',
            'text-emerald-600',
        ];

        $appointment = false;
        $appointment_id = ''; 

        if(isset($_GET['appointment'])){
            $appointment_id = $_GET['appointment'];
            $appointment = Appointment::select([
                "appointments.id",  
                DB::raw("CONCAT(doctors.title,' ',doctor_user.first_name,' ',doctor_user.last_name) AS fullnameDoctor"), 
                DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name) AS fullnamePatient"), 
                "appointments.patient_email",
                "appointments.patient_phone",  
                "appointments.subtotal", 
                "appointments.patient_dob",
                "appointments.patient_blood_type",
                "appointments.payment_status",
                "appointments.date",
                "appointments.status", 
                "appointments.discount",
                "appointments.subject",
                "appointments.allergies",
                "appointments.addictions",
                "appointments.addictions_text",
                "appointments.allergies",
                "appointments.allergies_text",
                "appointments.surgeries",
                "appointments.surgeries_text",
                "appointments.medications",
                "appointments.medications_text",
            ])
            ->leftJoin('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
            ->where('appointments.id', $_GET['appointment'])
            ->first();
        } 

        return view("public.profile",[  
            "medical_histories" => $medical_histories,
            "certificates" => $certificates, 
            'appointmentStatus' => $appointmentStatus, 
            'appointmentStatusColors' => $appointmentStatusColors,   
            'appointment' => $appointment,   
            'appointment_id' => $appointment_id,  
        ]);
    }

    public function appointment($id){
        $doctor = Doctor::findOr($id, function () {
            return false;
        });
        
        if(!$doctor){
            return redirect('/medicals/?msg='.__("messages.doctorNotExist")."_error");
        } 

        $doctor->user = User::find($doctor->user_id);
 
        $doctor->medical_units = MedicalUnit::select(["name","id"])->whereIn("medical_units.id", array_values(json_decode($doctor->medical_units,true)))->get(); 
        $medicalUnit = "";
        
        if(isset($_GET['medicalUnit'])){ 
            $medicalUnit = $_GET['medicalUnit']; 
        }

        $specialtyIds = json_decode($doctor->specialty_ids); 
        $translatedSpecialties = []; 

        foreach ($specialtyIds as $specialtyId) {
            $specialtyObj = Specialty::where('id', $specialtyId)->first();
            if ($specialtyObj) {
                $translatedSpecialties[] = __("specialties." . $specialtyObj->name);
            }
        }
        
        $doctor->specialties = $translatedSpecialties;

        $subjects = [];
        $prices = Setting::where(["module" => "appointments_prices"])->get();
        $times = Setting::where(["module" => "appointments_times"])->get();

        foreach ($prices as $price) {
            $subjects[] = $price->key;
        }

        return view("public.appointment",[ 
            "doctor" => $doctor,
            "medicalUnit" => $medicalUnit,
            "subjects" => $subjects,
            "prices" => $prices,
            "times" => $times,
        ]);
    }

    public function medicals($page = 1){

        $medicals = Doctor::select([
            'doctors.id as doctor_id',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fullname"),
            'users.email',
            'users.phone',
            'doctors.license',
            'doctors.specialty_ids', 
            'doctors.created_at',
            'users.image'
        ]);

        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $specialties = Specialty::select(["id","name"])->get();
        $medicalUnit = "";
        
        if(isset($_GET['medicalUnit'])){ 
            $medicalUnit = $_GET['medicalUnit'];
            $medicals = $medicals->whereJsonContains('medical_units', $_GET['medicalUnit']);
        } 
         
        return view("public.medicals",[ 
            //'medicals' => $medicals,
            'medicalUnits' => $medicalUnits,
            'medicalUnit' => $medicalUnit,
            "specialties" => $specialties,
            "page" => $page,
        ]);
    }
} 