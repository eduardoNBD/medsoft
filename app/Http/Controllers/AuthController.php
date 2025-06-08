<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Session,
    App,
    Validator,
    Auth,
    Hash,
    DB,
    Mail,
    File,
};
use App\Models\{
    User, 
    Doctor, 
    Patient,
    MedicalHistory,
    Setting
}; 
use Carbon\Carbon;
use App\Jobs\SendUserCreatedEmail;

class AuthController extends Controller{

    public function Login(Request $request){
        $validator = Validator::make(request()->all(), [
            'username' => 'required',
            'password' => 'required'
        ],
        [
            'username.required' => __('rules.username_required'),
            'password.required' => __('rules.password_required'),
        ]);
   
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $username = $request->input("username");
        $password = $request->input("password");

        $credentials = [
            'username' => $username,
            'password' => $password,
        ]; 

        if (Auth::attempt(['username' => $username, 'password' => $password]) || Auth::attempt(['email' => $username, 'password' => $password])) {
        
            $user = Auth::user();
            $url  = "dashboard";

            if($user->status != 0){ 
                Session::put('timezone', $request->input("timezone")); 

                if($user->role == 2){
                    $user->doctor = Doctor::where('user_id',$user->id)->get()[0];
                    Auth::setUser($user); 
                }

                if($user->role == 3){
                    $user->patient = Patient::where('user_id',$user->id)->get()[0];
                    Auth::setUser($user); 
                    $url  = "profile";
                }
                
                return response()->json(["status" => 1, "message" => "Logged", "url" => $url]);
            }

            Auth::logout();

            return response()->json(["status" => 0, "message" =>  __("messages.loginError")]);
        }
        else{
            return response()->json(["status" => 0, "message" =>  __("messages.loginError")]);
        }
    }

    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login");
    }

    public function Register(Request $request){
        
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
        $user->save();

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
        }

        if($request->input("role") == 2){
            $doctor = new Doctor;

            $doctor->user_id = $user->id;
            $doctor->title = $request->input("title"); 
            $doctor->license = $request->input("license");
            $doctor->commission_amount = 0;
            $doctor->timeslot = $request->input("timeslot"); 
            $doctor->offer_discount = $request->input("offer_discount") ? 1 : 0; 
            $doctor->specialty_ids = json_encode($request->input("specialties")); 
            $doctor->medical_units = json_encode($request->input("medical_unit"));  

            $doctor->save(); 
        }

        SendUserCreatedEmail::dispatch($user);  

        return response()->json(["status" => 1, "message" => __("messages.userCreated")]);
    } 

    public function Recovery(Request $request){
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email'
        ],
        [
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_email'),
        ]);
   
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $email = $request->input("email");

        $user = User::where('email', $email)->first();
        
        if($user){
            $token = Str::random(60);

            
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email], // Condición para buscar el registro
                [
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );

            $logos = Setting::select(['value'])->where("key","logos")->first();
            $logos = $logos ? json_decode($logos->value) : json_decode('{"logo_light":"", "logo_dark":""}');
            
            $imagePath = $logos->logo_dark 
            ? public_path("../resources/img/brand/").$logos->logo_dark 
            : public_path('../resources/img/brand/logo_white.svg');
        
            $imageData = File::get($imagePath);
            $mimeType = mime_content_type($imagePath);
            $base64 = base64_encode($imageData); 
    
            Mail::send("emails.".$user->language.'.reset-email', 
                [
                    'token' => $token,
                    'userFullName' => $user->first_name.' '.$user->last_name,
                    'resetLink' => url('/reset-password/'.$token),
                    'logoBase64' => 'data:' . $mimeType . ';base64,' . $base64

                ], 
                function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Enlace de restablecimiento de contraseña');
                }
            ); 

            return response()->json(["status" => 1, "message" => __("messages.emailRecoverySent")]);
        }

        return response()->json(["status" => 0, "message" => __("messages.emailNotFound")]);
    }

    public function Reset(Request $request){
        $validator = Validator::make(request()->all(), [
            'token' => 'required',
            'newPassword' => 'required|confirmed'
        ],
        [
            'token.required' => __('rules.token_required'),
            'newPassword.required' => __('rules.new_password_required'),
            'newPassword.confirmed' => __('rules.new_password_confirmed'),
        ]);
   
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $token = $request->input("token");
        $password = $request->input("newPassword");

        $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();
 
        if($passwordReset){
            $user = User::where('email', $passwordReset->email)->first();
            $user->password = Hash::make($password);
            $user->save();

            DB::table('password_reset_tokens')->where('token', $token)->delete();

            return response()->json(["status" => 1, "message" => __("messages.passwordChanged")]);
        }

        return response()->json(["status" => 0, "message" => __("messages.tokenNotFound")]);
    }
}