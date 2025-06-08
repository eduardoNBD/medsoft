<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Doctor,
    MedicalUnit,
    User,
    Patient,
    Specialty,
};

class MedicalsController extends Controller
{
    public function list(Request $request){ 
        $medicals = Doctor::leftJoin('users', 'users.id', '=', 'doctors.user_id') 
                        ->whereIn("doctors.status", $request->input("status"));

        if($request->input("s")){
            $medicals->where('users.first_name', 'like', $request->input("s") . '%')
                  ->orWhere('users.last_name', 'like', $request->input("s") . '%')
                  ->orWhere('users.email', 'like', $request->input("s") . '%')
                  ->orWhere('users.phone', 'like', $request->input("s") . '%')
                  ->orWhere('doctors.license', 'like', $request->input("s") . '%');
        }

        if($request->input("medicalUnit")){
            $medicals->whereJsonContains('medical_units', $request->input("medicalUnit"));
        }

        if($request->input("specialty")){
            $medicals->whereJsonContains('specialty_ids', $request->input("specialty"));
        }

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalMedical = $medicals->count();
        $totalPages = ceil($totalMedical / $perPage);

        $page = min($page, $totalPages);
        $dayText = strtolower(date('l'));

        $fields = [
            "doctors.id",   
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname"), 
            "users.id as user_id",
            "users.email",
            "users.phone",
            "users.role",
            "users.image",
            "doctors.specialty_ids",
            "doctors.title",
            "doctors.license", 
            "doctors.commission_amount",  
            "doctors.".$dayText."_start_time as start_time",
            "doctors.".$dayText."_end_time as end_time",
            "doctors.medical_units",
            "users.status",  
        ];

        $medicals = $medicals->paginate($perPage, $fields, 'doctor', $page);
        
        $medicals->getCollection()->transform(function ($item) { 
            $item->medical_units = MedicalUnit::select(["name",DB::raw("CONCAT(medical_units.address,', ',medical_units.city,', ',medical_units.zipcode,', ',medical_units.country) AS fulladdress")])->whereIn("medical_units.id", array_values(json_decode($item->medical_units,true)))->get(); 
            
            $specialtyIds = json_decode($item->specialty_ids); 
            $translatedSpecialties = []; 

            foreach ($specialtyIds as $specialtyId) {
                $specialtyObj = Specialty::where('id', $specialtyId)->first();
                if ($specialtyObj) {
                    $translatedSpecialties[] = __("specialties." . $specialtyObj->name);
                }
            }
         
            $item->specialties = $translatedSpecialties;

            return $item;
        });

        return response()->json(["status" => 1, 'items' => $medicals ]);
    }    

    public function delete(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        }
        
        $user->status = 0;
        $user->doctor->status = 0;
        $user->doctor->save();
        $user->save(); 

        return response()->json(["status" => 1, "message" => __("messages.doctorDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        }
        
        $user->status = 1;
        $user->doctor->status = 1;
        $user->doctor->save();
        $user->save(); 

        return response()->json(["status" => 1, "message" => __("messages.doctorRestored")]);
    }

    public function getData(Request $request, $id){ 
        $medical = Doctor::findOr($id, function () {
            return false;
        });

        $medical->medical_units = MedicalUnit::select(["id","name"])->whereIn("medical_units.id", array_values(json_decode($medical->medical_units,true)))->get();
        $patients = Patient::select(['patients.id as patient_id',DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fullname"),])
                            ->join('users', 'patients.user_id', '=', 'users.id')
                            ->where("patients.doctor_id",$id)->get();

        return response()->json([
            "status" => 1, 
            "medical_units" => $medical->medical_units,
            "patients" => $patients,
        ]);
    }
}



