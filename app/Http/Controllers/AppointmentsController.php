<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator, 
    Mail,
    Lang, 
    Auth,
    DB 
};
use Carbon\{
    Carbon,
    CarbonPeriod
};
use App\Models\{
    User,
    Doctor,
    Patient,
    Appointment,
    Encounter,
    MedicalUnit,
    Setting,
}; 
use Google\Client;
use Google\Service\Calendar;
use App\Jobs\{
    SendAppointmentCreatedEmail,
    SendAppointmentUpdatedEmail,
    SendAppointmentConfirmedEmail,
    SendAppointmentCanceledEmail,
    SendAppointmentCreatedEmailToDoctor
};
use App\Notifications\UserNotification; 

class AppointmentsController extends Controller
{
    public function create(Request $request){   
        $rules = [
            'doctor' => 'required',
            'subject' => 'required',
            'hour' => 'required|date_format:H:i', 
            'date' => 'required|date_format:Y-m-d',  
            'medical_unit' => 'required',
        ];
        
        $rulesText = [ 
            'doctor.required' => __('rules.doctor_required'), 
            'subject.required' => __('rules.subject_required'), 
            'hour.required' => __('rules.hour_required'),
            'hour.date_format' => __('rules.hour_date_format'),
            'date.required' => __('rules.date_required'),
            'date.date_format' => __('rules.date_date_format'),
            'medical_unit.required' => __('rules.medical_unit_required'), 
        ];

        if($request->input("timeslot")){
            $rules['timeslot'] = [ 
                'numeric', 
            ];
    
            $rulesText['timeslot.numeric'] = __('rules.timeslot_numeric');
            $rulesText['timeslot.min'] = __('rules.timeslot_min'); 
        }

        if(!$request->input("patient")){
            $rules['first_name'] = ['required'];
            $rules['last_name'] = ['required'];
            $rules['phone'] = ['required'];
            $rules['email'] = [
                'required',
                'email'
            ];
            $rules['bloodType'] = ['required'];
            $rules['dob'] = ['required'];

            $rulesText['phone.required'] = __('rules.phone_required');
            $rulesText['email.required'] = __('rules.email_required');
            $rulesText['email.email'] = __('rules.email_email');
            $rulesText['first_name.required'] = __('rules.first_name_required');
            $rulesText['last_name.required']  = __('rules.last_name_required');
            $rulesText['bloodType.required'] = __('rules.bloodType_required');
            $rulesText['dob.required'] = __('rules.dob_required');
        }

        if($request->input("allergies")){
            $rules['allergies_text'] = ['required'];
            $rulesText['allergies_text.required'] = __('rules.allergies_text_required');
        }
        if($request->input("surgeries")){
            $rules['surgeries_text'] = ['required'];
            $rulesText['surgeries_text.required'] = __('rules.surgeries_text_required');
        }
        if($request->input("addictions")){
            $rules['addictions_text'] = ['required'];
            $rulesText['addictions_text.required'] = __('rules.addictions_text_required');
        }
        if($request->input("medications")){
            $rules['medications_text'] = ['required'];
            $rulesText['medications_text.required'] = __('rules.medications_text_required');
        }
        
        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $doctor = Doctor::findOr($request->input("doctor"), function () {
            return false;
        });

        if(!$doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        } 

        $medicalUnit = MedicalUnit::findOr($request->input("medical_unit"), function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        } 

        $duration = $request->input("timeslot") ? $request->input("timeslot") : $doctor->timeslot;

        $appointment = new Appointment;
        $appointment->subject = $request->input("subject");
        $appointment->medical_unit_id = $request->input("medical_unit");
        $appointment->patient_id = $request->input("patient");
        $appointment->doctor_id = $request->input("doctor");
        $appointment->date = $request->input("date")." ".$request->input("hour").":00";
        $appointment->end_date = date('Y-m-d H:i:s', strtotime("+".$duration." minutes", strtotime($request->input("date")." ".$request->input("hour").":00")));
        $appointment->usePatient = $request->input("usePatientInfoCheck");
        $appointment->addictions = $request->input("addictions") ? 1 : 0;
        $appointment->addictions_text = $request->input("addictions_text");
        $appointment->allergies = $request->input("allergies") ? 1 : 0;
        $appointment->allergies_text = $request->input("allergies_text");
        $appointment->surgeries = $request->input("surgeries") ? 1 : 0;
        $appointment->surgeries_text = $request->input("surgeries_text");
        $appointment->medications = $request->input("medications") ? 1 : 0;
        $appointment->medications_text = $request->input("medications_text");
        $appointment->patient_dob = $request->input("dob");
        $appointment->patient_gender = $request->input("gender");
        $appointment->patient_first_name = $request->input("first_name");
        $appointment->patient_last_name = $request->input("last_name");
        $appointment->patient_email = $request->input("email");
        $appointment->patient_phone = $request->input("phone");
        $appointment->patient_language = $request->input("language");
        $appointment->patient_blood_type = $request->input("bloodType"); 
        $appointment->subtotal = str_replace('"',"",Setting::firstWhere('key', $request->input("subject"))->value);
        $appointment->discount = $request->input("discount",0) ? $request->input("discount") : 0;
        $appointment->origin = Auth::user()->role;
        $appointment->created_by = Auth::user()->id;
        $appointment->commission_amount = $doctor->commission_amount;

        if ($doctor->google_access_token && $doctor->google_refresh_token) {
            $this->addEventToGoogleCalendar($doctor, $appointment, $medicalUnit);
        }

        $appointment->save();

        SendAppointmentCreatedEmail::dispatch($appointment); 

        if(Auth::user()->role == 1){
            $user = User::find($doctor->user_id);
            $user->notify(new UserNotification(
                "notifications.newAppointment",
                "notifications.newAppointmentDoctor",  
                [
                    'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                    'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                    'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                    'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                    'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                ],
                '/dashboard/appointments?appointment='.$appointment->id,
                'appointments',
                $appointment->id,
                'info'
            ));

            if($appointment->patient_id){
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.newAppointment",
                    "notifications.newAppointmentPatient",  
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'info'
                ));
            }
        }

        if(Auth::user()->role == 2){
            if($appointment->patient_id){
                $user = User::find($doctor->user_id);
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.newAppointment",
                    "notifications.newAppointmentPatient",  
                    [
                        'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'info'
                ));
            }
        }

        if(Auth::user()->role == 3){
            $user = User::find($doctor->user_id);
            $user->notify(new UserNotification(
                "notifications.newAppointment",
                "notifications.newAppointmentDoctor",  
                [
                    'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                    'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                    'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                    'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                    'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                ],
                '/dashboard/appointments?appointment='.$appointment->id,
                'appointments',
                $appointment->id,
                'info'
            ));
            SendAppointmentCreatedEmailToDoctor::dispatch($appointment); 
        }

        if($request->input("date") == date("Y-m-d")){
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
            $encounter->created_by = Auth::user()->id;
            $encounter->commission_amount = $appointment->commission_amount;

            $encounter->save();
        }
        
        return response()->json(["status" => 1, "message" => __("messages.appointmentCreated")]);
    } 

    public function update(Request $request, $id){ 
        $rules = [ 
            'subject' => 'required',
            'hour' => 'required|date_format:H:i', 
            'date' => 'required|date_format:Y-m-d',  
            'medical_unit' => 'required',
        ];
        
        $rulesText = [  
            'subject.required' => __('rules.subject_required'), 
            'hour.required' => __('rules.hour_required'),
            'hour.date_format' => __('rules.hour_date_format'),
            'date.required' => __('rules.date_required'),
            'date.date_format' => __('rules.date_date_format'),
            'medical_unit.required' => __('rules.medical_unit_required'), 
        ];

        if($request->input("timeslot")){
            $rules['timeslot'] = [ 
                'numeric', 
            ];

            $rulesText['timeslot.numeric'] = __('rules.timeslot_numeric');
            $rulesText['timeslot.min'] = __('rules.timeslot_min'); 
        }

        if(!$request->input("patient")){
            $rules['first_name'] = ['required'];
            $rules['last_name'] = ['required'];
            $rules['phone'] = ['required'];
            $rules['email'] = [
                'required',
                'email'
            ];
            $rules['bloodType'] = ['required'];
            $rules['dob'] = ['required'];

            $rulesText['phone.required'] = __('rules.phone_required');
            $rulesText['email.required'] = __('rules.email_required');
            $rulesText['email.email'] = __('rules.email_email');
            $rulesText['first_name.required'] = __('rules.first_name_required');
            $rulesText['last_name.required']  = __('rules.last_name_required');
            $rulesText['bloodType.required'] = __('rules.bloodType_required');
            $rulesText['dob.required'] = __('rules.dob_required');
        }

        if($request->input("allergies")){
            $rules['allergies_text'] = ['required'];
            $rulesText['allergies_text.required'] = __('rules.allergies_text_required');
        }
        if($request->input("surgeries")){
            $rules['surgeries_text'] = ['required'];
            $rulesText['surgeries_text.required'] = __('rules.surgeries_text_required');
        }
        if($request->input("addictions")){
            $rules['addictions_text'] = ['required'];
            $rulesText['addictions_text.required'] = __('rules.addictions_text_required');
        }
        if($request->input("medications")){
            $rules['medications_text'] = ['required'];
            $rulesText['medications_text.required'] = __('rules.medications_text_required');
        }
        
        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        /*
        $title = Lang::get('messages.login_title', [], $request->input("language"))." ".config('app.name');
        $content = "<p>".Lang::get('texts.hello', [], $request->input("language")).", ".$request->input("first_name")." ".$request->input("last_name")."</p>
            <p>".Lang::get('texts.newUserText', [], $request->input("language")).": <strong>".$request->email."</strong></p>
            <p>".Lang::get('messages.username', [], $request->input("language")).": <strong>".$request->username."</strong></p>
            <p>".Lang::get('messages.password', [], $request->input("language")).": <strong>".$request->password."</strong></p>
            <p>".Lang::get('texts.textLinkLogin', [], $request->input("language")).": <strong><a href='".config('app.url')."/login'>".Lang::get('texts.here', [], $request->input("language"))."</a></strong></p>
            <p>".Lang::get('texts.thanks', [], $request->input("language"))."</p>
            <p>".Lang::get('texts.team', [], $request->input("language"))." ".config('app.name')."</p>";

        Mail::send('emails.welcome', [
                'title' => $title,
                'content' => $content,
            ], 
            function ($message) use ($request) {
                $message->to($request->email);
                $message->subject(Lang::get('texts.newUser', [], $request->input("language")));
            }
        );*/

        $appointment = Appointment::findOr($id, function () {
            return false;
        });

        if(!$appointment){
            return response()->json(["status" => 0, "message" => __("messages.appointmentNotExist")]);
        } 

        $doctor = Doctor::findOr($appointment->doctor_id, function () {
            return false;
        });

        if(!$doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        } 

        $medicalUnit = MedicalUnit::findOr($request->input("medical_unit"), function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        } 

        $duration = $request->input("timeslot") ? $request->input("timeslot") : $doctor->timeslot;
        
        $appointment->medical_unit_id = $request->input("medical_unit");
        $appointment->subject = $request->input("subject") ? $request->input("subject") : "";
        $appointment->date = $request->input("date")." ".$request->input("hour").":00";
        $appointment->end_date = date('Y-m-d H:i:s', strtotime("+".$duration." minutes", strtotime($request->input("date")." ".$request->input("hour").":00")));
        $appointment->usePatient = $request->input("usePatientInfoCheck");
        $appointment->addictions = $request->input("addictions") ? 1 : 0;
        $appointment->addictions_text = $request->input("addictions_text");
        $appointment->allergies = $request->input("allergies") ? 1 : 0;
        $appointment->allergies_text = $request->input("allergies_text");
        $appointment->surgeries = $request->input("surgeries") ? 1 : 0;
        $appointment->surgeries_text = $request->input("surgeries_text");
        $appointment->medications = $request->input("medications") ? 1 : 0;
        $appointment->medications_text = $request->input("medications_text");
        $appointment->patient_dob = $request->input("dob");
        $appointment->patient_gender = $request->input("gender");
        $appointment->patient_first_name = $request->input("first_name");
        $appointment->patient_last_name = $request->input("last_name");
        $appointment->patient_email = $request->input("email");
        $appointment->patient_phone = $request->input("phone");
        $appointment->patient_language = $request->input("language");
        $appointment->patient_blood_type = $request->input("bloodType"); 
        $appointment->subtotal = "100";
        $appointment->discount = $request->input("discount") ? $request->input("discount") : 0;
        $appointment->save();

        if(Auth::user()->role == 1){
            $user = User::find($doctor->user_id);
            $user->notify(new UserNotification(
                "notifications.updateAppointment",
                "notifications.updateAppointmentDoctor",  
                [
                    'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                    'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                    'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                    'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                    'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                ],
                '/dashboard/appointments?appointment='.$appointment->id,
                'appointments',
                $appointment->id,
                'info'
            ));

            if($appointment->patient_id){
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.updateAppointment",
                    "notifications.updateAppointmentPatient", 
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'info'
                ));
            }
        }

        if(Auth::user()->role == 2){
            if($appointment->patient_id){
                $user = User::find($doctor->user_id);
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.updateAppointment",
                    "notifications.updateAppointmentPatient",  
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'info'
                ));
            }
        } 

        if ($doctor->google_access_token && $doctor->google_refresh_token) {
            $this->updateEventInGoogleCalendar($doctor, $appointment,$medicalUnit);
        }

        if($request->input("sentEmail")){
            SendAppointmentUpdatedEmail::dispatch($appointment); 
        }

        $encounter = Encounter::where(['appointment_id' => $id])->first();
        
        if($request->input("date") == date("Y-m-d") && !$encounter){
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
            $encounter->created_by = Auth::user()->id;
            $encounter->commission_amount = $appointment->commission_amount;

            $encounter->save();
        }

        if($encounter){
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
            $encounter->created_by = Auth::user()->id;

            $encounter->save();
        }

        return response()->json(["status" => 1, "message" => __("messages.appointmentUpdate")]);
    }

    public function list(Request $request){ 
        $appointments = Appointment::leftJoin('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                                   ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
                                   ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
                                   ->leftJoin('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
                                   ->whereIn("appointments.status", $request->input("status")) 
                                   ->orderBy('appointments.date', 'asc');  


        if($request->input("s")){
            $appointments->where(DB::raw("CONCAT(doctors.title,' ',doctor_user.first_name,' ',doctor_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(doctor_user.first_name,' ',doctor_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere('subject', 'like', $request->input("s") . '%')
                  ->orWhere('appointments.id', '=', $request->input("s"));
        }

        if($request->input("start_date") && $request->input("end_date")){
            $appointments->where(function ($query) use ($request) {
                $start = Carbon::parse($request->input("start_date"));
                $end = Carbon::parse($request->input("end_date")." 23:59:59");
                $query->whereBetween('date', [$start, $end]);
            }); 
        }else{
            //$appointments->whereDate('date', '>=', Carbon::now()->format('Y-m-d'));
        }
 
        if(Auth::user()->role == 2){
            $doctor_id = Doctor::where('user_id',Auth::user()->id)->get()[0]->id;
            $appointments->where(function ($query) use ($doctor_id) {
                $query->where("appointments.doctor_id", $doctor_id);
            });
        }

        if(Auth::user()->role == 3){
            $user_id = Patient::where('user_id',Auth::user()->id)->get()[0]->id;
            $appointments->where(function ($query) use ($user_id) {
                $query->where("appointments.patient_id", $user_id);
            });
        }

        if($request->input("role") != ""){
            $appointments->where("role",$request->input("role"));
        }

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalAppointments = $appointments->count();
        $totalPages = ceil($totalAppointments / $perPage);

        $page = min($page, $totalPages);

        $fields = [
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
            "appointments.origin",
            'appointments.cancellation_reason'
        ];

        $appointments = $appointments->paginate($perPage, $fields, 'appointments', $page);
        
        $appointments->getCollection()->transform(function ($item) { 
            $item->subject = __("subjects." . $item->subject); //  
            return $item;
        });

        return response()->json(["status" => 1, 'items' => $appointments ]);
    } 

    public function delete(Request $request, $id){ 
        $appointment = Appointment::findOr($id, function () {
            return false;
        });

        if(!$appointment){
            return response()->json(["status" => 0, "message" => __("messages.appointmentNotExist")]);
        }
        
        $validator = Validator::make(request()->all(),[
            'cancellation_reason' => 'required'
        ],[
            'cancellation_reason.required' => __('rules.cancellation_reason_required')
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $doctor = Doctor::findOr($appointment->doctor_id, function () {
            return new Doctor;
        });
 
        $appointment->status = 0;
        $appointment->cancellation_reason = $request->input("cancellation_reason");
        $appointment->save(); 

        $encounter = Encounter::where(['appointment_id' => $id])->first();

        if($encounter){
            $current_items = json_decode($encounter->items); 
        
            foreach ($current_items as $key => $item) {
                if($item->type == "supply"){
                    $reload = ItemReload::find($item->item_reload_id);
                    $reload->remaining+= $item->qty;

                    $reload->save();
                }
            }
            
            $encounter->items = "[]";
            $encounter->status = 0;
            $encounter->cancellation_reason = $request->input("cancellation_reason");
            $encounter->save();
        }

        if ($doctor->google_access_token && $doctor->google_refresh_token) {
            $this->deleteEventFromGoogleCalendar($doctor, $appointment->event_id);
        }

        if(Auth::user()->role == 1){
            $user = User::find($doctor->user_id);
            $user->notify(new UserNotification(
                "notifications.cancelAppointment",
                "notifications.cancelAppointmentDoctor",  
                [
                    'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                    'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                    'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                    'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                    'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                ],
                '/dashboard/appointments?appointment='.$appointment->id,
                'appointments',
                $appointment->id,
                'error'
            ));

            if($appointment->patient_id){
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.cancelAppointment",
                    "notifications.cancelAppointmentPatient", 
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'error'
                ));
            }
        }

        if(Auth::user()->role == 2){
            if($appointment->patient_id){
                $user = User::find($doctor->user_id);
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.cancelAppointment",
                    "notifications.cancelAppointmentPatient", 
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'error'
                ));
            }
        }

        SendAppointmentCanceledEmail::dispatch($appointment); 

        return response()->json(["status" => 1, "message" => __("messages.appointmentDelete")]);
    } 

    public function confirm(Request $request, $id){ 
        $appointment = Appointment::findOr($id, function () {
            return false;
        });

        if(!$appointment){
            return response()->json(["status" => 0, "message" => __("messages.appointmentNotExist")]);
        }
        
        $encounter = Encounter::where(['appointment_id' => $id])->first();

        if($encounter){
            $appointment->status = 3; 
        }else{ 
            $appointment->status = 2; 
        }

        $doctor = Doctor::findOr($appointment->doctor_id, function () {
            return new Doctor;
        });

        if ($doctor->google_access_token && $doctor->google_refresh_token) {
            $this->confirmedEvent($doctor, $appointment);
        }

        $appointment->save(); 
        
        SendAppointmentConfirmedEmail::dispatch($appointment); 

        if(Auth::user()->role == 1){
            $user = User::find($doctor->user_id);
            $user->notify(new UserNotification(
                "notifications.confirmAppointment",
                "notifications.confirmAppointmentDoctor",  
                [
                    'patientFullName' => $appointment->patient_first_name." ".$appointment->patient_last_name,  
                    'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                    'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                    'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                    'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                ],
                '/dashboard/appointments?appointment='.$appointment->id,
                'appointments',
                $appointment->id,
                'success'
            ));

            if($appointment->patient_id){ 
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.confirmAppointment",
                    "notifications.confirmAppointmentPatient", 
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'success'
                ));
            }
        }

        if(Auth::user()->role == 2){
            if($appointment->patient_id){
                $user = User::find($doctor->user_id);
                $doctorName = $user->first_name." ".$user->last_name;
                $patient = Patient::find($appointment->patient_id);
                $user = User::find($patient->user_id);
                $user->notify(new UserNotification(
                    "notifications.confirmAppointment",
                    "notifications.confirmAppointmentPatient", 
                    [
                        'medicalFullName' => $doctorName, 
                        'appointmentDay' => \Carbon\Carbon::parse($appointment->date)->format('d'),
                        'appointmentMonth' => 'months.'.strtolower(\Carbon\Carbon::parse($appointment->date)->format('F')),
                        'appointmentYear' => \Carbon\Carbon::parse($appointment->date)->format('Y'),
                        'appointmentHour' => \Carbon\Carbon::parse($appointment->date)->format('H:i'),
                    ],
                    '/profile?appointment='.$appointment->id.'#tab-appointments',
                    'appointments',
                    $appointment->id,
                    'success'
                ));
            }
        }

        return response()->json(["status" => 1, "message" => __("messages.appointmentConfirm")]);
    } 

    public function generateEncounter(Request $request, $id){ 
        $appointment = Appointment::findOr($id, function () {
            return false;
        });

        if(!$appointment){
            return response()->json(["status" => 0, "message" => __("messages.appointmentNotExist")]);
        }
        
        $encounter = new Encounter;

        $appointment->status = 3; 
        $appointment->save(); 

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
        $encounter->created_by = Auth::user()->id;
        $encounter->commission_amount = $appointment->commission_amount;

        $encounter->save();

        return response()->json(["status" => 1, "message" => __("messages.encounterCreated")."... ".__("messages.redirecting"), "id" => $encounter->id]);
    } 
    
    public function getAvailableTimes(Request $request, $doctor_id) {
        if($request->input("timezone")){
            date_default_timezone_set($request->input("timezone"));
        } 
        
        $doctor = Doctor::findOr($doctor_id, function () {
            return false;
        });
    
        if (!$doctor) {
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);  
        } 
        
        $dayText = strtolower(date('l', strtotime($request->input("date"))));
        $selectedDate = Carbon::parse($request->input("date")); 
        $currentDate = Carbon::now();
 
        if ($doctor->{$dayText}) {
            if (!$selectedDate->greaterThan($currentDate)) {
                $current_time = Carbon::now();
                $doctor_start_time = Carbon::parse($request->input("date")." ".$doctor->{$dayText . "_start_time"});
    
                if ($current_time->lt($doctor_start_time)) {
                    $start_time = $doctor_start_time;
                } else {
                    $minutes = ceil($current_time->diffInMinutes($doctor_start_time) / $doctor->timeslot) * $doctor->timeslot;
                    $start_time = $doctor_start_time->copy()->addMinutes($minutes);
                }
            } else {
                $start_time = Carbon::parse($request->input("date")." ".$doctor->{$dayText . "_start_time"});
            }
             
            $timeslot = $doctor->timeslot;
            $end_time = Carbon::parse($request->input("date")." ".$doctor->{$dayText . "_end_time"});
            $end_time = $end_time->copy()->subMinute($timeslot);
             
            $period = CarbonPeriod::create($start_time, "{$timeslot} minutes", $end_time);
            $appointments = $doctor->appointments()
                ->whereDate('date', $request->input("date"))
                ->where('status', '!=', '0')
                ->when($request->input("id"), function ($query, $id) {
                    $query->where('id', '!=', $id);
                })
                ->get();
    
            $occupiedSlots = [];
    
            // Procesar citas del sistema
            foreach ($appointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->date);
                $appointmentEnd = Carbon::parse($appointment->end_date);
                $appointmentEnd = $appointmentEnd->copy()->subMinute(1);
                $appointmentPeriod = CarbonPeriod::create($appointmentStart, "{$timeslot} minutes", $appointmentEnd);
    
                foreach ($appointmentPeriod as $slot) {
                    $occupiedSlots[] = $slot->format('H:i');
                }
            }
    
            $availableSlots = [];

            if($doctor->google_access_token && $doctor->google_refresh_token){
                $googleEvents = $this->getGoogleCalendarEvents($doctor, $request->input("date"));
            }
            
             
            foreach ($period as $slot) {

                $existInGoogle = false;

                if($doctor->google_access_token && $doctor->google_refresh_token){
                    foreach($googleEvents as $event){ 
                        $start = Carbon::parse($event['start']);
                        $end = Carbon::parse($event['end']);
                        
                        if ($slot->between($start, $end)) {
                            $existInGoogle = true; 
                            break;
                        }
                    }
                }
                
                if (!in_array($slot->format('H:i'), $occupiedSlots) && !$existInGoogle) {
                    $availableSlots[] = $slot->format('H:i');
                }
            }
 
            return response()->json(["status" => 1, "availableSlots" => $availableSlots]);
        } else {
            return response()->json(["status" => 1, "availableSlots" => []]);
        }
    }

    private function initializeGoogleClient($doctor, $scopes) {
        $client = new \Google\Client();
        $client->setApplicationName('unidadmedicavph');
        $client->setScopes($scopes);
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->setAccessToken($doctor->google_access_token);
    
        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($doctor->google_refresh_token);
            $doctor->google_access_token = $newToken['access_token'];
            $doctor->save();
        }
    
        return $client;
    }
    
    private function createOrUpdateEvent($service, $calendarId, $event, $eventId = null) {
        if ($eventId) {
            $existingEvent = $service->events->get($calendarId, $eventId);
            $existingEvent->setSummary($event['summary']);
            $existingEvent->setLocation($event['location']);
            $existingEvent->setDescription($event['description']);
            $existingEvent->setStart($event['start']);
            $existingEvent->setEnd($event['end']);
            $existingEvent->setAttendees($event['attendees']);
            return $service->events->update($calendarId, $eventId, $existingEvent);
        } else {
            return $service->events->insert($calendarId, $event);
        }
    }
    
    private function addEventToGoogleCalendar($doctor, $appointment, $medicalUnit) {
        $client = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);
    
        $event = new \Google\Service\Calendar\Event([
            'summary' => __('subjects.' . $appointment->subject),
            'location' => $medicalUnit->address . ', ' . $medicalUnit->city . ', ' . $medicalUnit->state . ', ' . $medicalUnit->zipcode . ', ' . $medicalUnit->country,
            'description' => '<strong>'.__('routes.patient') .':</strong> ' . $appointment->patient_first_name . ' ' . $appointment->patient_last_name . '<br><strong>' . __('messages.phone') . ':</strong> ' . $appointment->patient_phone . '<br><strong>' . __('messages.email') . ':</strong> ' . $appointment->patient_email . '<br><strong>' . __('messages.gender') . ':</strong> ' . __('messages.' . $appointment->patient_gender) . '<br><strong>' . __('routes.appointment') . ' ' . __('messages.pending'),
            'start' => [
                'dateTime' => Carbon::parse($appointment->date)->toIso8601String(),
                'timeZone' => session('timezone'),
            ],
            'end' => [
                'dateTime' => $appointment->end_date->toIso8601String(),
                'timeZone' => session('timezone'),
            ],
            'attendees' => [
                ['email' => $appointment->patient_email],
                ['email' => Auth::user()->email],
            ],
        ]);
    
        try {
            $createdEvent = $this->createOrUpdateEvent($service, 'primary', $event);
            $appointment->event_id = $createdEvent->getId();
            $appointment->save();
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    }
    
    private function updateEventInGoogleCalendar($doctor, $appointment, $medicalUnit) {
        $client = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);
    
        $event = [
            'summary' => __('subjects.' . $appointment->subject),
            'location' => $medicalUnit->address . ', ' . $medicalUnit->city . ', ' . $medicalUnit->state . ', ' . $medicalUnit->zipcode . ', ' . $medicalUnit->country,
            'description' => '<strong>'.__('routes.patient') .':</strong> ' . $appointment->patient_first_name . ' ' . $appointment->patient_last_name . '<br><strong>' . __('messages.phone') . ':</strong> ' . $appointment->patient_phone . '<br><strong>' . __('messages.email') . ':</strong> ' . $appointment->patient_email . '<br><strong>' . __('messages.gender') . ':</strong> ' . __('messages.' . $appointment->patient_gender) . '<br><strong>' . __('routes.appointment') . ' ' . __('messages.pending'),
            'start' => new \Google\Service\Calendar\EventDateTime([
                'dateTime' => Carbon::parse($appointment->date)->toIso8601String(),
                'timeZone' => session('timezone'),
            ]),
            'end' => new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $appointment->end_date->toIso8601String(),
                'timeZone' => session('timezone'),
            ]),
            'attendees' => [
                ['email' => $appointment->patient_email],
                ['email' => Auth::user()->email],
            ],
        ];
    
        try {
            $this->createOrUpdateEvent($service, 'primary', $event, $appointment->event_id);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    }
    
    private function deleteEventFromGoogleCalendar($doctor, $eventId) {
        $client = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);
    
        try {
            $service->events->delete('primary', $eventId);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    }

    public function confirmedEvent($doctor, $appointment)
    {
        $client = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);

        try {
            $eventId = $appointment->event_id;
            $event = $service->events->get('primary', $eventId);

            $event->setDescription('<strong>'.__('routes.patient') .':</strong> ' . $appointment->patient_first_name . ' ' . $appointment->patient_last_name . '<br><strong>' . __('messages.phone') . ':</strong> ' . $appointment->patient_phone . '<br><strong>' . __('messages.email') . ':</strong> ' . $appointment->patient_email . '<br><strong>' . __('messages.gender') . ':</strong> ' . __('messages.' . $appointment->patient_gender) . '<br><strong>' . __('routes.appointment') . ' ' . __('messages.confirmed'));
            $updatedEvent = $service->events->update('primary', $eventId, $event);

            return $updatedEvent;
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    }
    
    private function getGoogleCalendarEvents($doctor, $date) {
        $client = $this->initializeGoogleClient($doctor, \Google\Service\Calendar::CALENDAR_READONLY);
        $service = new \Google\Service\Calendar($client);
    
        $timeMin = Carbon::parse($date)->startOfDay()->toRfc3339String();
        $timeMax = Carbon::parse($date)->endOfDay()->toRfc3339String();
    
        $optParams = [
            'timeMin' => $timeMin,
            'timeMax' => $timeMax,
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ];
    
        try {
            $events = $service->events->listEvents('primary', $optParams);
    
            $eventData = [];
            foreach ($events->getItems() as $event) {
                $start = $event->start->dateTime ?? $event->start->date;
                $end = $event->end->dateTime ?? $event->end->date;
    
                $eventData[] = [
                    'start' => $start,
                    'end' => $end,
                ];
            }
    
            return $eventData;
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, 'message' => $e->getMessage()]);
            exit;
        }
    }
}



