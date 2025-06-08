<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator, 
    Auth,
    Mail,
    Lang,
    DB,
    Storage,
    File,
};
use App\Models\{
    User,
    Doctor,
    Patient,
    MedicalHistory,
    MedicalUnit, 
    Specialty,
}; 
use App\Jobs\SendUserCreatedEmail;

class UsersController extends Controller
{
    public function create(Request $request){
        
        $rules = [
            'username' => 'required|regex:/^\S*$/u|unique:users', 
            'role' => 'required', 
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users', 
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed',  
            'language' => 'required',
        ];

        $rulesText = [
            'username.unique' => __('rules.username_unique'), 
            'username.required' => __('rules.username_required'), 
            'username.regex' => __('rules.username_regex'),  
            'role.required' => __('rules.role_required'),
            'first_name.required' => __('rules.first_name_required'),
            'last_name.required' => __('rules.last_name_required'),
            'email.unique' => __('rules.email_unique'),
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_email'),
            'phone.required' => __('rules.phone_required'),
            'phone.unique' => __('rules.phone_unique'),
            'password.required' => __('rules.password_required'),
            'password.confirmed' => __('rules.password_confirmed'),  
            'language.required' => __('rules.language_required'),
        ];

        if($request->input("role") == 2){
            $filteredSpecialties = array_filter($request->input('specialties', []), function ($value) {
                return !is_null($value) && $value !== '';
            });
             
            $request->merge(['specialties' => $filteredSpecialties]);

            $rules['specialties'] = [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) { 
                    $existingSpecialtiesCount = DB::table('specialties')->whereIn('id', $value)->count();
                    if ($existingSpecialtiesCount !== count($value)) {
                        $fail(__('rules.specialties_invalid'));
                    }
                }
            ];
        
            $rules['license'] = ['required'];
            $rules['commission'] = [
                'required',
                'numeric',
                'max:90',    
            ];
            $rules['timeslot'] = [
                'required',
                'numeric',
                'min:15',  
            ]; 
            $rules['medical_unit']= ['required'];
            
            $rulesText['specialties.required'] = __('rules.specialties_required');
            $rulesText['license.required'] = __('rules.license_required');
            $rulesText['commission.required'] = __('rules.commission_required');
            $rulesText['commission.numeric'] = __('rules.commission_numeric');
            $rulesText['commission.max'] = __('rules.commission_max');
            $rulesText['timeslot.required'] = __('rules.timeslot_required');
            $rulesText['timeslot.numeric'] = __('rules.timeslot_numeric');
            $rulesText['timeslot.min'] = __('rules.timeslot_min');  
            $rulesText['medical_unit.required'] = __('rules.medical_unit_required');

            if($request->input("monday")){
                $rules['monday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:monday_end_time'
                ];

                $rules['monday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:monday_start_time'
                ];

                $rulesText['monday_start_time.required'] = __('rules.monday_start_time_required');
                $rulesText['monday_start_time.date_format'] = __('rules.monday_start_time_date_format');
                $rulesText['monday_start_time.before'] = __('rules.monday_start_time_before'); 
                $rulesText['monday_end_time.required'] = __('rules.monday_end_time_required');
                $rulesText['monday_end_time.date_format'] = __('rules.monday_end_time_date_format');
                $rulesText['monday_end_time.after'] = __('rules.monday_end_time_after'); 
            }
            if($request->input("tuesday")){
                $rules['tuesday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:tuesday_end_time'
                ];

                $rules['tuesday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:tuesday_start_time'
                ];

                $rulesText['tuesday_start_time.required'] = __('rules.tuesday_start_time_required');
                $rulesText['tuesday_start_time.date_format'] = __('rules.tuesday_start_time_date_format');
                $rulesText['tuesday_start_time.before'] = __('rules.tuesday_start_time_before'); 
                $rulesText['tuesday_end_time.required'] = __('rules.tuesday_end_time_required');
                $rulesText['tuesday_end_time.date_format'] = __('rules.tuesday_end_time_date_format');
                $rulesText['tuesday_end_time.after'] = __('rules.tuesday_end_time_after'); 
            }
            if($request->input("wednesday")){
                $rules['wednesday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:wednesday_end_time'
                ];

                $rules['wednesday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:wednesday_start_time'
                ];

                $rulesText['wednesday_start_time.required'] = __('rules.wednesday_start_time_required');
                $rulesText['wednesday_start_time.date_format'] = __('rules.wednesday_start_time_date_format');
                $rulesText['wednesday_start_time.before'] = __('rules.wednesday_start_time_before'); 
                $rulesText['wednesday_end_time.required'] = __('rules.wednesday_end_time_required');
                $rulesText['wednesday_end_time.date_format'] = __('rules.wednesday_end_time_date_format');
                $rulesText['wednesday_end_time.after'] = __('rules.wednesday_end_time_after'); 
            }
            if($request->input("thursday")){
                $rules['thursday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:thursday_end_time'
                ];

                $rules['thursday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:thursday_start_time'
                ];

                $rulesText['thursday_start_time.required'] = __('rules.thursday_start_time_required');
                $rulesText['thursday_start_time.date_format'] = __('rules.thursday_start_time_date_format');
                $rulesText['thursday_start_time.before'] = __('rules.thursday_start_time_before'); 
                $rulesText['thursday_end_time.required'] = __('rules.thursday_end_time_required');
                $rulesText['thursday_end_time.date_format'] = __('rules.thursday_end_time_date_format');
                $rulesText['thursday_end_time.after'] = __('rules.thursday_end_time_after'); 
            }
            if($request->input("friday")){
                $rules['friday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:friday_end_time'
                ];

                $rules['friday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:friday_start_time'
                ];

                $rulesText['friday_start_time.required'] = __('rules.friday_start_time_required');
                $rulesText['friday_start_time.date_format'] = __('rules.friday_start_time_date_format');
                $rulesText['friday_start_time.before'] = __('rules.friday_start_time_before'); 
                $rulesText['friday_end_time.required'] = __('rules.friday_end_time_required');
                $rulesText['friday_end_time.date_format'] = __('rules.friday_end_time_date_format');
                $rulesText['friday_end_time.after'] = __('rules.friday_end_time_after'); 
            }
            if($request->input("saturday")){
                $rules['saturday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:saturday_end_time'
                ];

                $rules['saturday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:saturday_start_time'
                ];

                $rulesText['saturday_start_time.required'] = __('rules.saturday_start_time_required');
                $rulesText['saturday_start_time.date_format'] = __('rules.saturday_start_time_date_format');
                $rulesText['saturday_start_time.before'] = __('rules.saturday_start_time_before'); 
                $rulesText['saturday_end_time.required'] = __('rules.saturday_end_time_required');
                $rulesText['saturday_end_time.date_format'] = __('rules.saturday_end_time_date_format');
                $rulesText['saturday_end_time.after'] = __('rules.saturday_end_time_after'); 
            }
            if($request->input("sunday")){
                $rules['sunday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:sunday_end_time'
                ];

                $rules['sunday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:sunday_start_time'
                ];

                $rulesText['sunday_start_time.required'] = __('rules.sunday_start_time_required');
                $rulesText['sunday_start_time.date_format'] = __('rules.sunday_start_time_date_format');
                $rulesText['sunday_start_time.before'] = __('rules.sunday_start_time_before'); 
                $rulesText['sunday_end_time.required'] = __('rules.sunday_end_time_required');
                $rulesText['sunday_end_time.date_format'] = __('rules.sunday_end_time_date_format');
                $rulesText['sunday_end_time.after'] = __('rules.sunday_end_time_after'); 
            }
        }
        

        if($request->input("role") == 3){
            $rules['bloodType'] = ['required'];
            $rules['patient_country'] = ['required'];
            $rules['patient_zipcode'] = ['required'];
            $rules['patient_city'] = ['required'];
            $rules['patient_state'] = ['required'];
            $rules['patient_address'] = ['required'];
            $rules['dob'] = ['required'];

            $rulesText['bloodType.required'] = __('rules.bloodType_required'); 
            $rulesText['patient_country.required'] = __('rules.country_required'); 
            $rulesText['patient_zipcode.required'] = __('rules.zipcode_required'); 
            $rulesText['patient_city.required'] = __('rules.city_required'); 
            $rulesText['patient_state.required'] = __('rules.state_required'); 
            $rulesText['patient_address.required'] = __('rules.address_required'); 
            $rulesText['dob.required'] = __('rules.dob_required'); 
        }

        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $user = new User;
         
        $user->username = $request->input("username");
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->phone = $request->input("phone");
        $user->password = Hash::make($request->input("password"));
        $user->role = $request->input("role");
        $user->language = $request->input("language");
        $user->gender = $request->input("gender");  
        $user->created_by = Auth::user()->id;
        $user->save();
        
        $main  = $request->file("imgUser");
        $image = "";
        
        if($main){
            $image = $main->store("gallery/".$user->id); 
            $user->image = $image; 
              
            $user->save();
        }

        $messageReturn = __("messages.userCreated");
        $redirect      = "users";

        if($request->input("role") == 3){
            $patient = new Patient;
            
            $patient->user_id = $user->id;
            $patient->dob = $request->input("dob");
            $patient->address = $request->input("patient_address");
            $patient->city = $request->input("patient_city");
            $patient->state = $request->input("patient_state");
            $patient->country = $request->input("patient_country");
            $patient->zipcode = $request->input("patient_zipcode");
            $patient->blood_type = $request->input("bloodType");
            $patient->doctor_id = $request->input("doctor");

            $patient->save();

            $medicalHistory = MedicalHistory::create([
                'patient_id' => $patient->id, 
            ]);

            $messageReturn = __("messages.patientCreated");
            $redirect      = "patients";
        }

        if($request->input("role") == 2){
            $doctor = new Doctor;

            $doctor->user_id = $user->id;
            $doctor->title = $request->input("title"); 
            $doctor->license = $request->input("license");
            $doctor->commission_amount = $request->input("commission");
            $doctor->timeslot = $request->input("timeslot"); 
            $doctor->offer_discount = $request->input("offer_discount") ? 1 : 0; 
            $doctor->specialty_ids = json_encode($request->input("specialties")); 
            $doctor->medical_units = json_encode($request->input("medical_unit")); 
            $doctor->monday = 0; 
            $doctor->monday_end_time = ""; 
            $doctor->monday_start_time = ""; 
            $doctor->tuesday = 0; 
            $doctor->tuesday_end_time = ""; 
            $doctor->tuesday_start_time = ""; 
            $doctor->wednesday = 0; 
            $doctor->wednesday_end_time = ""; 
            $doctor->wednesday_start_time = ""; 
            $doctor->thursday = 0; 
            $doctor->thursday_end_time = ""; 
            $doctor->thursday_start_time = ""; 
            $doctor->friday = 0; 
            $doctor->friday_end_time = ""; 
            $doctor->friday_start_time = ""; 
            $doctor->saturday = 0; 
            $doctor->saturday_end_time = ""; 
            $doctor->saturday_start_time = ""; 
            $doctor->sunday = 0; 
            $doctor->sunday_end_time = ""; 
            $doctor->sunday_start_time =""; 

            if($request->input("monday")){
                $doctor->monday = 1; 
                $doctor->monday_end_time = $request->input("monday_end_time"); 
                $doctor->monday_start_time = $request->input("monday_start_time"); 
            }

            if($request->input("tuesday")){
                $doctor->tuesday = 1; 
                $doctor->tuesday_end_time = $request->input("tuesday_end_time"); 
                $doctor->tuesday_start_time = $request->input("tuesday_start_time"); 
            }

            if($request->input("wednesday")){
                $doctor->wednesday = 1; 
                $doctor->wednesday_end_time = $request->input("wednesday_end_time"); 
                $doctor->wednesday_start_time = $request->input("wednesday_start_time"); 
            }

            if($request->input("thursday")){
                $doctor->thursday = 1; 
                $doctor->thursday_end_time = $request->input("thursday_end_time"); 
                $doctor->thursday_start_time = $request->input("thursday_start_time"); 
            }

            if($request->input("friday")){
                $doctor->friday = 1; 
                $doctor->friday_end_time = $request->input("friday_end_time"); 
                $doctor->friday_start_time = $request->input("friday_start_time"); 
            }

            if($request->input("saturday")){
                $doctor->saturday = 1; 
                $doctor->saturday_end_time = $request->input("saturday_end_time"); 
                $doctor->saturday_start_time = $request->input("saturday_start_time"); 
            }

            if($request->input("sunday")){
                $doctor->sunday = 1; 
                $doctor->sunday_end_time = $request->input("sunday_end_time"); 
                $doctor->sunday_start_time = $request->input("sunday_start_time"); 
            } 

            $doctor->save();

            $messageReturn = __("messages.doctorCreated");
            $redirect      = "medicals";
        }

        SendUserCreatedEmail::dispatch($user); 
 
        require getcwd()."/config/menu.php"; 
        return response()->json(["status" => 1, "message" => $messageReturn, "redirect" => config('app.url').$routes[$redirect]['root']]);
    } 

    public function update(Request $request, $id){  
        $user = User::findOr($id, function () {
            return false;
        });
  
        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.userDelete")]);
        }

        $rules = [
            'username' => 'required|regex:/^\S*$/u|unique:users,username,'.$id,  
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id, 
            'language' => 'required',
        ];

        $rulesText = [
            'username.unique' => __('rules.username_exists'), 
            'username.required' => __('rules.username_required'), 
            'username.regex' => __('rules.username_regex'),   
            'first_name.required' => __('rules.first_name_required'),
            'last_name.required' => __('rules.last_name_required'),
            'email.unique' => __('rules.email_unique'),
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_email'),
            'phone.required' => __('rules.phone_required'),
            'phone.unique' => __('rules.phone_unique'), 
            'language.required' => __('rules.language_required'),
        ];

        if($user->role == 2){
            $filteredSpecialties = array_filter($request->input('specialties', []), function ($value) {
                return !is_null($value) && $value !== '';
            });
            
            // Reemplaza el input specialties con el array filtrado
            $request->merge(['specialties' => $filteredSpecialties]);

            $rules['specialties'] = [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    // Verificar que cada specialty exista en la tabla specialties
                    $existingSpecialtiesCount = DB::table('specialties')->whereIn('id', $value)->count();
                    if ($existingSpecialtiesCount !== count($value)) {
                        $fail(__('rules.specialties_invalid'));
                    }
                }
            ];
        
            $rules['license'] = ['required'];
            $rules['commission'] = [
                'required',
                'numeric',
                'max:90',    
            ];
            $rules['timeslot'] = [
                'required',
                'numeric',
                'min:15',  
            ]; 

            $rulesText['specialties.required'] = __('rules.specialties_required');
            $rulesText['license.required'] = __('rules.license_required');
            $rulesText['commission.required'] = __('rules.commission_required');
            $rulesText['commission.numeric'] = __('rules.commission_numeric');
            $rulesText['commission.max'] = __('rules.commission_max');
            $rulesText['timeslot.required'] = __('rules.timeslot_required');
            $rulesText['timeslot.numeric'] = __('rules.timeslot_numeric');
            $rulesText['timeslot.min'] = __('rules.timeslot_min');  

            if($request->input("monday")){
                $rules['monday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:monday_end_time'
                ];

                $rules['monday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:monday_start_time'
                ];

                $rulesText['monday_start_time.required'] = __('rules.monday_start_time_required');
                $rulesText['monday_start_time.date_format'] = __('rules.monday_start_time_date_format');
                $rulesText['monday_start_time.before'] = __('rules.monday_start_time_before'); 
                $rulesText['monday_end_time.required'] = __('rules.monday_end_time_required');
                $rulesText['monday_end_time.date_format'] = __('rules.monday_end_time_date_format');
                $rulesText['monday_end_time.after'] = __('rules.monday_end_time_after'); 
            }
            if($request->input("tuesday")){
                $rules['tuesday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:tuesday_end_time'
                ];

                $rules['tuesday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:tuesday_start_time'
                ];

                $rulesText['tuesday_start_time.required'] = __('rules.tuesday_start_time_required');
                $rulesText['tuesday_start_time.date_format'] = __('rules.tuesday_start_time_date_format');
                $rulesText['tuesday_start_time.before'] = __('rules.tuesday_start_time_before'); 
                $rulesText['tuesday_end_time.required'] = __('rules.tuesday_end_time_required');
                $rulesText['tuesday_end_time.date_format'] = __('rules.tuesday_end_time_date_format');
                $rulesText['tuesday_end_time.after'] = __('rules.tuesday_end_time_after'); 
            }
            if($request->input("wednesday")){
                $rules['wednesday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:wednesday_end_time'
                ];

                $rules['wednesday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:wednesday_start_time'
                ];

                $rulesText['wednesday_start_time.required'] = __('rules.wednesday_start_time_required');
                $rulesText['wednesday_start_time.date_format'] = __('rules.wednesday_start_time_date_format');
                $rulesText['wednesday_start_time.before'] = __('rules.wednesday_start_time_before'); 
                $rulesText['wednesday_end_time.required'] = __('rules.wednesday_end_time_required');
                $rulesText['wednesday_end_time.date_format'] = __('rules.wednesday_end_time_date_format');
                $rulesText['wednesday_end_time.after'] = __('rules.wednesday_end_time_after'); 
            }
            if($request->input("thursday")){
                $rules['thursday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:thursday_end_time'
                ];

                $rules['thursday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:thursday_start_time'
                ];

                $rulesText['thursday_start_time.required'] = __('rules.thursday_start_time_required');
                $rulesText['thursday_start_time.date_format'] = __('rules.thursday_start_time_date_format');
                $rulesText['thursday_start_time.before'] = __('rules.thursday_start_time_before'); 
                $rulesText['thursday_end_time.required'] = __('rules.thursday_end_time_required');
                $rulesText['thursday_end_time.date_format'] = __('rules.thursday_end_time_date_format');
                $rulesText['thursday_end_time.after'] = __('rules.thursday_end_time_after'); 
            }
            if($request->input("friday")){
                $rules['friday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:friday_end_time'
                ];

                $rules['friday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:friday_start_time'
                ];

                $rulesText['friday_start_time.required'] = __('rules.friday_start_time_required');
                $rulesText['friday_start_time.date_format'] = __('rules.friday_start_time_date_format');
                $rulesText['friday_start_time.before'] = __('rules.friday_start_time_before'); 
                $rulesText['friday_end_time.required'] = __('rules.friday_end_time_required');
                $rulesText['friday_end_time.date_format'] = __('rules.friday_end_time_date_format');
                $rulesText['friday_end_time.after'] = __('rules.friday_end_time_after'); 
            }
            if($request->input("saturday")){
                $rules['saturday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:saturday_end_time'
                ];

                $rules['saturday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:saturday_start_time'
                ];

                $rulesText['saturday_start_time.required'] = __('rules.saturday_start_time_required');
                $rulesText['saturday_start_time.date_format'] = __('rules.saturday_start_time_date_format');
                $rulesText['saturday_start_time.before'] = __('rules.saturday_start_time_before'); 
                $rulesText['saturday_end_time.required'] = __('rules.saturday_end_time_required');
                $rulesText['saturday_end_time.date_format'] = __('rules.saturday_end_time_date_format');
                $rulesText['saturday_end_time.after'] = __('rules.saturday_end_time_after'); 
            }
            if($request->input("sunday")){
                $rules['sunday_start_time'] = [
                    'required',
                    'date_format:H:i',
                    'before:sunday_end_time'
                ];

                $rules['sunday_end_time'] = [
                    'required',
                    'date_format:H:i',
                    'after:sunday_start_time'
                ];

                $rulesText['sunday_start_time.required'] = __('rules.sunday_start_time_required');
                $rulesText['sunday_start_time.date_format'] = __('rules.sunday_start_time_date_format');
                $rulesText['sunday_start_time.before'] = __('rules.sunday_start_time_before'); 
                $rulesText['sunday_end_time.required'] = __('rules.sunday_end_time_required');
                $rulesText['sunday_end_time.date_format'] = __('rules.sunday_end_time_date_format');
                $rulesText['sunday_end_time.after'] = __('rules.sunday_end_time_after'); 
            }
        }
        

        if($user->role == 3){
            $rules['bloodType'] = ['required'];
            $rules['patient_country'] = ['required'];
            $rules['patient_zipcode'] = ['required'];
            $rules['patient_city'] = ['required'];
            $rules['patient_state'] = ['required'];
            $rules['patient_address'] = ['required'];
            $rules['dob'] = ['required'];

            $rulesText['bloodType.required'] = __('rules.bloodType_required'); 
            $rulesText['patient_country.required'] = __('rules.country_required'); 
            $rulesText['patient_zipcode.required'] = __('rules.zipcode_required'); 
            $rulesText['patient_city.required'] = __('rules.city_required'); 
            $rulesText['patient_state.required'] = __('rules.state_required'); 
            $rulesText['patient_address.required'] = __('rules.address_required'); 
            $rulesText['dob.required'] = __('rules.dob_required'); 
        }

        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        if($user->role == 3){ 
            $patient = Patient::findOr($user->patient->id, function () {
                return false;
            });
    
            if(!$patient){
                return response()->json(["status" => 0, "message" => __("messages.patientNotExist")]);
            } 
        }
        
        if($user->role == 2){ 
            $doctor = Doctor::findOr($user->doctor->id, function () {
                return false;
            });
    
            if(!$doctor){
                return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
            } 
        }
        
        $user->username = $request->input("username");
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->phone = $request->input("phone"); 
        $user->language = $request->input("language"); 
        $user->gender = $request->input("gender");  

        $user->save();

        $main  = $request->file("imgUser");
        $image = $user->image ? $user->image : "";

        if($main){
            $image =  $main->store("gallery/".$user->id); 

            if($user->image != "0" && $user->image != "" && Storage::exists($user->image)) {
                Storage::delete($user->image); 
            } 
        }

        if($request->input("maindeleted")){
            if($user->image != "0" && $user->image != "" && Storage::exists($user->image)) {
                Storage::delete($user->image); 
                $image = "";
            } 
        }

        $user->image = $image; 

        $user->save();

        if($id == Auth::user()->id){
            Auth::setUser($user);
        }

        $messageReturn = __("messages.userUpdate");
        $redirect      = "users";

        if($user->role == 3){  
            $patient->user_id = $user->id;
            $patient->dob = $request->input("dob");
            $patient->address = $request->input("patient_address");
            $patient->city = $request->input("patient_city");
            $patient->state = $request->input("patient_state");
            $patient->country = $request->input("patient_country");
            $patient->zipcode = $request->input("patient_zipcode");
            $patient->blood_type = $request->input("bloodType");
            $patient->doctor_id = $request->input("doctor");

            $patient->save();

            $messageReturn = __("messages.patientUpdate");
            $redirect      = "patients";
        }

        if($user->role == 2){  
            $doctor->user_id = $user->id;
            $doctor->title = $request->input("title"); 
            $doctor->license = $request->input("license");
            $doctor->commission_amount = $request->input("commission");
            $doctor->timeslot = $request->input("timeslot"); 
            $doctor->offer_discount = $request->input("offer_discount") ? 1 : 0; 
            $doctor->specialty_ids = json_encode(array_values($request->input("specialties")));
            $doctor->medical_units = json_encode($request->input("medical_unit"));  

            $doctor->monday = 0; 
            $doctor->monday_end_time = ""; 
            $doctor->monday_start_time = ""; 
            $doctor->tuesday = 0; 
            $doctor->tuesday_end_time = ""; 
            $doctor->tuesday_start_time = ""; 
            $doctor->wednesday = 0; 
            $doctor->wednesday_end_time = ""; 
            $doctor->wednesday_start_time = ""; 
            $doctor->thursday = 0; 
            $doctor->thursday_end_time = ""; 
            $doctor->thursday_start_time = ""; 
            $doctor->friday = 0; 
            $doctor->friday_end_time = ""; 
            $doctor->friday_start_time = ""; 
            $doctor->saturday = 0; 
            $doctor->saturday_end_time = ""; 
            $doctor->saturday_start_time = ""; 
            $doctor->sunday = 0; 
            $doctor->sunday_end_time = ""; 
            $doctor->sunday_start_time =""; 

            if($request->input("monday")){
                $doctor->monday = 1; 
                $doctor->monday_end_time = $request->input("monday_end_time"); 
                $doctor->monday_start_time = $request->input("monday_start_time"); 
            }

            if($request->input("tuesday")){
                $doctor->tuesday = 1; 
                $doctor->tuesday_end_time = $request->input("tuesday_end_time"); 
                $doctor->tuesday_start_time = $request->input("tuesday_start_time"); 
            }

            if($request->input("wednesday")){
                $doctor->wednesday = 1; 
                $doctor->wednesday_end_time = $request->input("wednesday_end_time"); 
                $doctor->wednesday_start_time = $request->input("wednesday_start_time"); 
            }

            if($request->input("thursday")){
                $doctor->thursday = 1; 
                $doctor->thursday_end_time = $request->input("thursday_end_time"); 
                $doctor->thursday_start_time = $request->input("thursday_start_time"); 
            }

            if($request->input("friday")){
                $doctor->friday = 1; 
                $doctor->friday_end_time = $request->input("friday_end_time"); 
                $doctor->friday_start_time = $request->input("friday_start_time"); 
            }

            if($request->input("saturday")){
                $doctor->saturday = 1; 
                $doctor->saturday_end_time = $request->input("saturday_end_time"); 
                $doctor->saturday_start_time = $request->input("saturday_start_time"); 
            }

            if($request->input("sunday")){
                $doctor->sunday = 1; 
                $doctor->sunday_end_time = $request->input("sunday_end_time"); 
                $doctor->sunday_start_time = $request->input("sunday_start_time"); 
            } 

            $doctor->save();

            $messageReturn = __("messages.doctorUpdate");
            $redirect      = "medicals";
        }

        require getcwd()."/config/menu.php"; 
        return response()->json(["status" => 1, "message" => $messageReturn, "redirect" => config('app.url').$routes[$redirect]['root']]);
    }

    public function list(Request $request){ 
        $users = User::leftJoin('doctors', 'users.id', '=', 'doctors.user_id')
                     ->leftJoin('patients', 'users.id', '=', 'patients.user_id')
                     ->whereIn("users.status", $request->input("status"));

        if($request->input("s"))
        {
            $users->where('first_name', 'like', $request->input("s") . '%')
                  ->orWhere('last_name', 'like', $request->input("s") . '%')
                  ->orWhere('email', 'like', $request->input("s") . '%')
                  ->orWhere('phone', 'like', $request->input("s") . '%')
                  ->orWhere('username', 'like', $request->input("s") . '%');
        }

        if($request->input("role") != ""){
            $users->where("role",$request->input("role"));
        }

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalUsers = $users->count();
        $totalPages = ceil($totalUsers / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "users.id", 
            "users.username", 
            "users.image", 
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname"), 
            "users.email",
            "users.phone",
            "users.role",
            "doctors.specialty_ids",
            "doctors.title",
            "doctors.license", 
            "doctors.commission_amount",
            "patients.address",
            "patients.city",
            "patients.zipcode",
            "patients.city",
            "patients.country",
            "patients.dob",
            "patients.blood_type",
            "users.status", 
            "doctors.medical_units",
        ];

        $users = $users->paginate($perPage, $fields, 'users', $page);
        
        $users->getCollection()->transform(function ($item) {  
            if($item->role == 2){
                $specialtyIds = json_decode($item->specialty_ids); 
                $translatedSpecialties = []; 

                foreach ($specialtyIds as $specialtyId) {
                    $specialtyObj = Specialty::where('id', $specialtyId)->first();
                    if ($specialtyObj) {
                        $translatedSpecialties[] = __("specialties." . $specialtyObj->name);
                    }
                }
                
                $item->specialties = $translatedSpecialties;
                $item->medical_units = MedicalUnit::select(["name"])->whereIn("medical_units.id", array_values(json_decode($item->medical_units,true)))->get(); 
            }

            return $item;
        });


        return response()->json(["status" => 1, 'items' => $users ]);
    } 

    public function delete(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }
        
        $user->status = 0;
        $user->save(); 

        return response()->json(["status" => 1, "message" => __("messages.userDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }
        
        $user->status = 1;
        $user->save(); 

        return response()->json(["status" => 1, "message" => __("messages.userRestored")]);
    } 

    public function updateProfile(Request $request){ 
        $validator = Validator::make(request()->all(), [
            'username' => 'required|unique:users,username,'.Auth::id(),
            'first_name' => 'required',
            'last_name' => 'required', 
            'email' => 'required|unique:users,email,'.Auth::id(),
            'language' => 'required',
            'phone' => 'required|unique:users,phone,'.Auth::id(),
        ],
        [ 
            'username.required' => __("rules.username_required"),
            'first_name.required' => __("rules.first_name_required"),
            'last_name.required' => __("rules.last_name_required"),
            'email.required' => __("rules.email_required"),
            'phone.required' => __("rules.phone_required"),
            'phone.unique' =>  __("rules.phone_unique"), 
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $user = User::findOr(Auth::id(), function () {
            return false;
        });
         
        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }
        
        $user->username = $request->input("username");
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name"); 
        $user->phone = $request->input("phone");  
        $user->email = $request->input("email");  
        $user->language = $request->input("language");  
        $user->gender = $request->input("gender");  

        $user->save(); 

        Auth::setUser($user);

        return response()->json(["status" => 1, "message" => __("messages.profileSaved")]);
    }

    public function updateProfilePhoto(Request $request){ 
        $user = User::findOr(Auth::id(), function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0){
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }

        $main  = $request->file("imgUser");
        $image = $user->image ? $user->image : "";
        $msm   = "";

        if($main){
            $image =  $main->store("gallery/".$user->id); 

            if($user->image != "0" && $user->image != "" && Storage::exists($user->image)) {
                Storage::delete($user->image); 
            } 

            $msg = __("messages.profilePhotoChanged");
        }else{
            if($user->image != "0" && $user->image != "" && Storage::exists($user->image)) {
                Storage::delete($user->image); 
                $image = "";
            } 

            $msg = __("messages.profilePhotoDeleted");
        }

        $user->image = $image; 

        $user->save(); 
        
        Auth::setUser($user); 

        return response()->json(["status" => 1, "message" => $msg ]);
    }

    function updateProfileDoctor(Request $request){ 
        $user = User::findOr(Auth::id(), function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0){
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }

        $user->doctor = Doctor::findOr($user->doctor->id, function () {
            return false;
        });

        if(!$user->doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        } 

        $filteredSpecialties = array_filter($request->input('specialties', []), function ($value) {
            return !is_null($value) && $value !== '';
        });
         
        $request->merge(['specialties' => $filteredSpecialties]);

        $rules = [];
        $rulesText = [];

        $rules['specialties'] = [
            'required',
            'array',
            'min:1',
            function ($attribute, $value, $fail) { 
                $existingSpecialtiesCount = DB::table('specialties')->whereIn('id', $value)->count();
                if ($existingSpecialtiesCount !== count($value)) {
                    $fail(__('rules.specialties_invalid'));
                }
            }
        ];

        $rules['license'] = ['required'];
        
        $rules['timeslot'] = [
            'required',
            'numeric',
            'min:15',  
        ]; 
        
        $rules['medical_unit']= ['required'];
        
        $rulesText['specialties.required'] = __('rules.specialties_required');
        $rulesText['license.required'] = __('rules.license_required'); 
        $rulesText['timeslot.required'] = __('rules.timeslot_required');
        $rulesText['timeslot.numeric'] = __('rules.timeslot_numeric');
        $rulesText['timeslot.min'] = __('rules.timeslot_min');  
        $rulesText['medical_unit.required'] = __('rules.medical_unit_required');
        
        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $user->doctor->title = $request->input("title"); 
        $user->doctor->license = $request->input("license"); 
        $user->doctor->timeslot = $request->input("timeslot"); 
        $user->doctor->specialty_ids = json_encode(array_values($request->input("specialties")));
        $user->doctor->medical_units = json_encode($request->input("medical_unit"));  
        $user->doctor->save(); 
        
        Auth::setUser($user); 

        return response()->json(["status" => 1, "message" => __("messages.doctorProfileUpdated") ]);
    }

    public function updateProfilePatient(Request $request){  
        $user = User::findOr(Auth::id(), function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0){
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }

        $user->patient = Patient::findOr($user->patient->id, function () {
            return false;
        });

        if(!$user->patient){
            return response()->json(["status" => 0, "message" => __("messages.patientNotExist")]);
        } 

        $rules = [];
        $rulesText = [];  
        $rules['bloodType'] = ['required'];
        $rules['patient_country'] = ['required'];
        $rules['patient_zipcode'] = ['required'];
        $rules['patient_city'] = ['required'];
        $rules['patient_state'] = ['required'];
        $rules['patient_address'] = ['required'];
        $rules['dob'] = ['required'];

        $rulesText['bloodType.required'] = __('rules.bloodType_required'); 
        $rulesText['patient_country.required'] = __('rules.country_required'); 
        $rulesText['patient_zipcode.required'] = __('rules.zipcode_required'); 
        $rulesText['patient_city.required'] = __('rules.city_required'); 
        $rulesText['patient_state.required'] = __('rules.state_required'); 
        $rulesText['patient_address.required'] = __('rules.address_required'); 
        $rulesText['dob.required'] = __('rules.dob_required'); 
       

        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }  

        $user->patient->user_id = $user->id;
        $user->patient->dob = $request->input("dob");
        $user->patient->address = $request->input("patient_address");
        $user->patient->city = $request->input("patient_city");
        $user->patient->state = $request->input("patient_state");
        $user->patient->country = $request->input("patient_country");
        $user->patient->zipcode = $request->input("patient_zipcode");
        $user->patient->blood_type = $request->input("bloodType"); 

        $user->patient->save();
        
        Auth::setUser($user);

        return response()->json(["status" => 1, "message" => __("messages.profileSaved") ]);
    }

    function updateSchedules(Request $request){ 
        $user = User::findOr(Auth::id(), function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0){
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }

        $user->doctor = Doctor::findOr($user->doctor->id, function () {
            return false;
        });

        if(!$user->doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        }  

        $rules = [];
        $rulesText = [];

        if($request->input("monday")){
            $rules['monday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:monday_end_time'
            ];

            $rules['monday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:monday_start_time'
            ];

            $rulesText['monday_start_time.required'] = __('rules.monday_start_time_required');
            $rulesText['monday_start_time.date_format'] = __('rules.monday_start_time_date_format');
            $rulesText['monday_start_time.before'] = __('rules.monday_start_time_before'); 
            $rulesText['monday_end_time.required'] = __('rules.monday_end_time_required');
            $rulesText['monday_end_time.date_format'] = __('rules.monday_end_time_date_format');
            $rulesText['monday_end_time.after'] = __('rules.monday_end_time_after'); 
        }
        if($request->input("tuesday")){
            $rules['tuesday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:tuesday_end_time'
            ];

            $rules['tuesday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:tuesday_start_time'
            ];

            $rulesText['tuesday_start_time.required'] = __('rules.tuesday_start_time_required');
            $rulesText['tuesday_start_time.date_format'] = __('rules.tuesday_start_time_date_format');
            $rulesText['tuesday_start_time.before'] = __('rules.tuesday_start_time_before'); 
            $rulesText['tuesday_end_time.required'] = __('rules.tuesday_end_time_required');
            $rulesText['tuesday_end_time.date_format'] = __('rules.tuesday_end_time_date_format');
            $rulesText['tuesday_end_time.after'] = __('rules.tuesday_end_time_after'); 
        }
        if($request->input("wednesday")){
            $rules['wednesday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:wednesday_end_time'
            ];

            $rules['wednesday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:wednesday_start_time'
            ];

            $rulesText['wednesday_start_time.required'] = __('rules.wednesday_start_time_required');
            $rulesText['wednesday_start_time.date_format'] = __('rules.wednesday_start_time_date_format');
            $rulesText['wednesday_start_time.before'] = __('rules.wednesday_start_time_before'); 
            $rulesText['wednesday_end_time.required'] = __('rules.wednesday_end_time_required');
            $rulesText['wednesday_end_time.date_format'] = __('rules.wednesday_end_time_date_format');
            $rulesText['wednesday_end_time.after'] = __('rules.wednesday_end_time_after'); 
        }
        if($request->input("thursday")){
            $rules['thursday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:thursday_end_time'
            ];

            $rules['thursday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:thursday_start_time'
            ];

            $rulesText['thursday_start_time.required'] = __('rules.thursday_start_time_required');
            $rulesText['thursday_start_time.date_format'] = __('rules.thursday_start_time_date_format');
            $rulesText['thursday_start_time.before'] = __('rules.thursday_start_time_before'); 
            $rulesText['thursday_end_time.required'] = __('rules.thursday_end_time_required');
            $rulesText['thursday_end_time.date_format'] = __('rules.thursday_end_time_date_format');
            $rulesText['thursday_end_time.after'] = __('rules.thursday_end_time_after'); 
        }
        if($request->input("friday")){
            $rules['friday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:friday_end_time'
            ];

            $rules['friday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:friday_start_time'
            ];

            $rulesText['friday_start_time.required'] = __('rules.friday_start_time_required');
            $rulesText['friday_start_time.date_format'] = __('rules.friday_start_time_date_format');
            $rulesText['friday_start_time.before'] = __('rules.friday_start_time_before'); 
            $rulesText['friday_end_time.required'] = __('rules.friday_end_time_required');
            $rulesText['friday_end_time.date_format'] = __('rules.friday_end_time_date_format');
            $rulesText['friday_end_time.after'] = __('rules.friday_end_time_after'); 
        }
        if($request->input("saturday")){
            $rules['saturday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:saturday_end_time'
            ];

            $rules['saturday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:saturday_start_time'
            ];

            $rulesText['saturday_start_time.required'] = __('rules.saturday_start_time_required');
            $rulesText['saturday_start_time.date_format'] = __('rules.saturday_start_time_date_format');
            $rulesText['saturday_start_time.before'] = __('rules.saturday_start_time_before'); 
            $rulesText['saturday_end_time.required'] = __('rules.saturday_end_time_required');
            $rulesText['saturday_end_time.date_format'] = __('rules.saturday_end_time_date_format');
            $rulesText['saturday_end_time.after'] = __('rules.saturday_end_time_after'); 
        }
        if($request->input("sunday")){
            $rules['sunday_start_time'] = [
                'required',
                'date_format:H:i',
                'before:sunday_end_time'
            ];

            $rules['sunday_end_time'] = [
                'required',
                'date_format:H:i',
                'after:sunday_start_time'
            ];

            $rulesText['sunday_start_time.required'] = __('rules.sunday_start_time_required');
            $rulesText['sunday_start_time.date_format'] = __('rules.sunday_start_time_date_format');
            $rulesText['sunday_start_time.before'] = __('rules.sunday_start_time_before'); 
            $rulesText['sunday_end_time.required'] = __('rules.sunday_end_time_required');
            $rulesText['sunday_end_time.date_format'] = __('rules.sunday_end_time_date_format');
            $rulesText['sunday_end_time.after'] = __('rules.sunday_end_time_after'); 
        }
        
        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $user->doctor->monday = 0; 
        $user->doctor->monday_end_time = ""; 
        $user->doctor->monday_start_time = ""; 
        $user->doctor->tuesday = 0; 
        $user->doctor->tuesday_end_time = ""; 
        $user->doctor->tuesday_start_time = ""; 
        $user->doctor->wednesday = 0; 
        $user->doctor->wednesday_end_time = ""; 
        $user->doctor->wednesday_start_time = ""; 
        $user->doctor->thursday = 0; 
        $user->doctor->thursday_end_time = ""; 
        $user->doctor->thursday_start_time = ""; 
        $user->doctor->friday = 0; 
        $user->doctor->friday_end_time = ""; 
        $user->doctor->friday_start_time = ""; 
        $user->doctor->saturday = 0; 
        $user->doctor->saturday_end_time = ""; 
        $user->doctor->saturday_start_time = ""; 
        $user->doctor->sunday = 0; 
        $user->doctor->sunday_end_time = ""; 
        $user->doctor->sunday_start_time =""; 

        if($request->input("monday")){
            $user->doctor->monday = 1; 
            $user->doctor->monday_end_time = $request->input("monday_end_time"); 
            $user->doctor->monday_start_time = $request->input("monday_start_time"); 
        }

        if($request->input("tuesday")){
            $user->doctor->tuesday = 1; 
            $user->doctor->tuesday_end_time = $request->input("tuesday_end_time"); 
            $user->doctor->tuesday_start_time = $request->input("tuesday_start_time"); 
        }

        if($request->input("wednesday")){
            $user->doctor->wednesday = 1; 
            $user->doctor->wednesday_end_time = $request->input("wednesday_end_time"); 
            $user->doctor->wednesday_start_time = $request->input("wednesday_start_time"); 
        }

        if($request->input("thursday")){
            $user->doctor->thursday = 1; 
            $user->doctor->thursday_end_time = $request->input("thursday_end_time"); 
            $user->doctor->thursday_start_time = $request->input("thursday_start_time"); 
        }

        if($request->input("friday")){
            $user->doctor->friday = 1; 
            $user->doctor->friday_end_time = $request->input("friday_end_time"); 
            $user->doctor->friday_start_time = $request->input("friday_start_time"); 
        }

        if($request->input("saturday")){
            $user->doctor->saturday = 1; 
            $user->doctor->saturday_end_time = $request->input("saturday_end_time"); 
            $user->doctor->saturday_start_time = $request->input("saturday_start_time"); 
        }

        if($request->input("sunday")){
            $user->doctor->sunday = 1; 
            $user->doctor->sunday_end_time = $request->input("sunday_end_time"); 
            $user->doctor->sunday_start_time = $request->input("sunday_start_time"); 
        }
        $user->doctor->save(); 
        
        Auth::setUser($user); 

        return response()->json(["status" => 1, "message" => __("messages.doctorSchedulesUpdated") ]);
    }

    public function updatePassword(Request $request){ 
        $validator = Validator::make(request()->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ],
        [ 
            'old_password.required' => __("rules.old_password_required"),  
            'new_password.required' => __("rules.new_password_required"), 
            'new_password_confirmation.required' =>  __("rules.new_password_confirmation_required"),  
            'new_password.confirmed' => __("rules.new_password_confirmed"),  
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $user = Auth::user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return response()->json(['status' => 0, 'message' => __("messages.wrongPassword")]);
        }
     
        $user->password = Hash::make($request->input('new_password'));
        $user->save(); 

        return response()->json(["status" => 1, "message" => __("messages.passwordChanged") ]);
    }

    public function updatePasswordForUser(Request $request,$id) {
        $validator = Validator::make($request->all(), [ 
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ],
        [ 
            'user_id.required' => 'Campo <strong>Usuario</strong> es requerido',
            'user_id.exists' => 'El <strong>Usuario</strong> no existe',
            'new_password.required' => 'Campo <strong>Nueva contraseña</strong> es requerido', 
            'new_password_confirmation.required' => 'Campo <strong>Confirmar nueva contraseña</strong> es requerido',  
            'new_password.confirmed' => 'Campo <strong>Nueva contraseña</strong> debe coincidir con el <strong>Confirmar nueva Contraseña</strong>',
        ]);
    
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }
    
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.userDelete")]);
        }
    
        $user->password = Hash::make($request->input('new_password'));
        $user->save(); 
    
        return response()->json(["status" => 1, "message" => __("messages.passwordChangedForUSer")]);
    }
    
    public function credentials(Request $request){
        $doctor = auth()->user()->doctor;   
        $doctor->google_access_token = "";
        $doctor->google_refresh_token = "";

        $doctor->save();

        return response()->json(["status" => 1, "message" => __("messages.accountDesLinked")]); 
    }

    public function setNoRemember(Request $request){ 
        $user = User::findOr(Auth::id(), function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.userNotExist")]);
        }

        if($user->status == 0){
            return response()->json(["status" => 0, "message" => __("messages.userDeleted")]);
        }

        $user->doctor = Doctor::findOr($user->doctor->id, function () {
            return false;
        });

        if(!$user->doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        }  
        
        $user->doctor->google_credentials_remember = true;

        $user->doctor->save(); 
        
        Auth::setUser($user); 
        
        return response()->json(["status" => 1, "message" => __("messages.accountDesLinked")]); 
    }
}



