<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator, 
    Auth, 
    DB,
    Storage,
};
use App\Models\MedicalUnit;  

class MedicalUnitsController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'name' => 'required:unique:medical_units', 
            'email' => 'required|email|unique:medical_units', 
            'phone' => 'required|unique:users', 
            'address' => 'required', 
            'city' => 'required', 
            'state' => 'required', 
            'zipcode' => 'required', 
            'country' => 'required', 
        ],
        [
            'name.required' => __('rules.name_required'),
            'name.unique' => __('rules.name_unique'),
            'email.unique' => __('rules.email_unique'),
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_email'),
            'phone.required' => __('rules.phone_required'),
            'phone.unique' => __('rules.phone_unique'),
            'address.required' => __('rules.address_required'),
            'city.required' => __('rules.city_required'),
            'state.required'  => __('rules.state_required'),
            'zipcode.required' => __('rules.zipcode_required'),
            'country.required' => __('rules.country_required'),
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $medicalUnit = new MedicalUnit;
         
        $medicalUnit->name = $request->input("name"); 
        $medicalUnit->email = $request->input("email");
        $medicalUnit->phone = $request->input("phone");   
        $medicalUnit->address = $request->input("address"); 
        $medicalUnit->city = $request->input("city");
        $medicalUnit->state = $request->input("state");   
        $medicalUnit->zipcode = $request->input("zipcode");
        $medicalUnit->country = $request->input("country");    
        $medicalUnit->created_by = Auth::user()->id;

        $medicalUnit->save();
        
        $main  = $request->file("imgMedicalUnit");
        $image = "";
        
        if($main){
            $image = $main->store("gallery/".$medicalUnit->id); 
            $medicalUnit->logo = $image; 
              
            $medicalUnit->save();
        }

        return response()->json(["status" => 1, "message" => __("messages.medicalUnitCreated")]);
    } 

    public function update(Request $request, $id){  
        $medicalUnit = MedicalUnit::findOr($id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        }

        if($medicalUnit->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitDelete")]);
        }

        $validator = Validator::make(request()->all(), [
            'name' => 'required:unique:medical_units,name,'.$id,  
            'email' => 'required|email|unique:medical_units,email,'.$id, 
            'phone' => 'required|unique:users', 
            'address' => 'required', 
            'city' => 'required', 
            'state' => 'required', 
            'zipcode' => 'required', 
            'country' => 'required', 
        ],
        [
            'name.required' => __('rules.name_required'),
            'name.unique' => __('rules.name_unique'),
            'email.unique' => __('rules.email_unique'),
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_email'),
            'phone.required' => __('rules.phone_required'),
            'phone.unique' => __('rules.phone_unique'),
            'address.required' => __('rules.address_required'),
            'city.required' => __('rules.city_required'),
            'state.required'  => __('rules.state_required'),
            'zipcode.required' => __('rules.zipcode_required'),
            'country.required' => __('rules.country_required'),
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 
         
        $medicalUnit->name = $request->input("name"); 
        $medicalUnit->email = $request->input("email");
        $medicalUnit->phone = $request->input("phone");   
        $medicalUnit->address = $request->input("address"); 
        $medicalUnit->city = $request->input("city");
        $medicalUnit->state = $request->input("state");   
        $medicalUnit->zipcode = $request->input("zipcode");
        $medicalUnit->country = $request->input("country");   

        $medicalUnit->save();
         
        $image = "";
        
        $main  = $request->file("imgMedicalUnit");
        $image = $medicalUnit->logo ? $medicalUnit->logo : "";

        if($main){
            $image =  $main->store("gallery/".$medicalUnit->id); 

            if($medicalUnit->logo != "0" && $medicalUnit->logo != "" && Storage::exists($medicalUnit->logo)) {
                Storage::delete($medicalUnit->logo); 
            } 
        }

        if($request->input("maindeleted")){
            if($medicalUnit->logo != "0" && $medicalUnit->logo != "" && Storage::exists($medicalUnit->logo)) {
                Storage::delete($medicalUnit->logo); 
                $image = "";
            } 
        }

        $medicalUnit->logo = $image; 
         
        $medicalUnit->save();

        return response()->json(["status" => 1, "message" => __("messages.medicalUnitUpdate")]);
    }

    public function list(Request $request){ 
        $medicalUnits = MedicalUnit::whereIn("medical_units.status", $request->input("status"));

        if($request->input("s"))
        {
            $medicalUnits->where('medical_units.name', 'like', $request->input("s") . '%')
                ->orWhere('medical_units.address', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.city', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.state', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.country', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.zipcode', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.phone', 'like', $request->input("s") . '%') 
                ->orWhere('medical_units.email', 'like', $request->input("s") . '%') 
                ->orWhere(DB::raw("CONCAT(medical_units.address,', ',medical_units.city,', ',medical_units.zipcode,', ',medical_units.country)"), 'like', $request->input("s") . '%');
        } 

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalMedicalUnits = $medicalUnits->count();
        $totalPages = ceil($totalMedicalUnits / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "medical_units.id", 
            "medical_units.name", 
            "medical_units.phone",
            "medical_units.email",  
            "medical_units.status", 
            "medical_units.logo",  
            DB::raw("CONCAT(medical_units.address,', ',medical_units.city,', ',medical_units.zipcode,', ',medical_units.country) AS fulladdress"),  
        ];

        $medicalUnits = $medicalUnits->paginate($perPage, $fields, 'medical_units', $page);
         
        return response()->json(["status" => 1, 'items' => $medicalUnits ]);
    } 

    public function delete(Request $request, $id){ 
        $medicalUnit = MedicalUnit::findOr($id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        }
        
        $medicalUnit->status = 0;
        $medicalUnit->save(); 

        return response()->json(["status" => 1, "message" => __("messages.medicalUnitDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $medicalUnit = MedicalUnit::findOr($id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        }
        
        $medicalUnit->status = 1;
        $medicalUnit->save(); 

        return response()->json(["status" => 1, "message" => __("messages.medicalUnitRestored")]);
    } 
}



