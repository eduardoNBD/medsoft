<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator,  
    Storage,
    DB,
    Auth, 
    File
};
use App\Models\{
    MedicalUnit,
    Certificate,
    Patient,
    Doctor,
    Setting,
    CertificateRequest,
    User,
};  
use App\Jobs\{
    SendCertificateGenerateEmail,  
};
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\UserNotification; 

class CertificatesController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'content' => 'required',
            'medical_unit' => 'required', 
            'doctor' => 'required', 
            'patient' => 'required',  
            'title' => 'required',  
            'type' => 'required',  
        ],
        [
            'content.required' => __('rules.content_required'),
            'medical_unit.required' => __('rules.medical_unit_required'),  
            'doctor.required' => __('rules.doctor_required'),
            'patient.required' => __('rules.patient_required'),
            'title.required' => __('rules.title_required'),
            'type.required' => __('rules.type_required'),
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $certificate = new Certificate;
         
        $certificate->content = $request->input("content");
        $certificate->medical_unit_id = $request->input("medical_unit");
        $certificate->notes = $request->input("notes");
        $certificate->patient_id = $request->input("patient");
        $certificate->doctor_id = $request->input("doctor"); 
        $certificate->title = $request->input("title"); 
        $certificate->type = $request->input("type"); 
        $certificate->expires_at = $request->input("expires_at",null); 
        $certificate->created_by = Auth::user()->id;
        
        $certificate->save();
         
        if($request->input("request_id")){
            $request = CertificateRequest::find($request->input("request_id"));
            $request->certificate_id = $certificate->id;
            $request->status = 2;
            $request->save();
        }

        $types = [
            1 => "messages.medicalCertificate",
            2 => "messages.certificate",
            3 => "messages.recipe",
        ];

        $patient = Patient::find($certificate->patient_id);
        $user = User::find($patient->user_id); 
        $user = User::find($patient->user_id);
        $user->notify(new UserNotification(
            "notifications.newDocument",
            "notifications.newDocumentPatient",  
            [
                'typeDocument' => $types[$certificate->type]
            ],
            '/profile?certificate='.$certificate->id.'#tab-certificate',
            'certificates',
            $certificate->id,
            'info'
        ));

        SendCertificateGenerateEmail::dispatch($certificate);

        return response()->json(["status" => 1, "message" => __("messages.certificateCreated")]);
    } 

    public function update(Request $request, $id){  
        $certificate = certificate::findOr($id, function () {
            return false;
        });

        if(!$certificate){
            return response()->json(["status" => 0, "message" => __("messages.certificateNotExist")]);
        }

        if($certificate->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.certificateDelete")]);
        }
        
        $medicalUnit = MedicalUnit::findOr($certificate->medical_unit_id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        } 
        
        $patient = Patient::findOr($certificate->patient_id, function () {
            return false;
        });

        if(!$patient){
            return response()->json(["status" => 0, "message" => __("messages.patientNotExist")]);
        } 

        $validator = Validator::make(request()->all(), 
            [
                'content' => 'required',  
                'title' => 'required',  
                'type' => 'required', 
            ],
            [
                'content.required' => __('rules.content_required'),
                'title.required' => __('rules.title_required'),
                'type.required' => __('rules.type_required'),
            ]
        );
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }  
         
        $certificate->content = $request->input("content");
        $certificate->medical_unit_id = $request->input("medical_unit");
        $certificate->notes = $request->input("notes"); 
        $certificate->title = $request->input("title"); 
        $certificate->type = $request->input("type"); 
        $certificate->expires_at = $request->input("expires_at",null); 

        $certificate->save(); 

        return response()->json(["status" => 1, "message" => __("messages.certificateUpdate")]);
    }

    public function list(Request $request){ 
        $certificates = Certificate::leftJoin('medical_units', 'medical_units.id', '=', 'certificates.medical_unit_id')  
                                   ->leftJoin('patients', 'patients.id', '=', 'certificates.patient_id')  
                                   ->leftJoin('doctors', 'doctors.id', '=', 'certificates.doctor_id')
                                   ->leftJoin('users as patientUser', 'patientUser.id', '=', 'patients.user_id') 
                                   ->leftJoin('users as doctorUser', 'doctorUser.id', '=', 'doctors.user_id') 
                                   ->whereIn("certificates.status", $request->input("status"));

        if(Auth::user()->role == 2){
            $user_id = Doctor::where('user_id',Auth::user()->id)->get()[0]->id;
            $certificates->where(function ($query) use ($user_id) {
                $query->where("certificates.doctor_id", $user_id);
            });
        }

        if($request->input("s")){
            $search = $request->input("s");
        
            $certificates->where(function ($query) use ($search) {
                $query->where('certificates.notes', 'like', $search . '%')
                    ->orWhere(DB::raw("CONCAT(doctorUser.first_name,' ',doctorUser.last_name)"), 'like', $search . '%')
                    ->orWhere(DB::raw("CONCAT(patientUser.first_name,' ',patientUser.last_name)"), 'like', $search . '%');
            });
        } 

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalCertificates = $certificates->count();
        $totalPages = ceil($totalCertificates / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "certificates.id",
            "certificates.notes",
            "certificates.created_at",
            "certificates.status",
            DB::raw("CONCAT(patientUser.first_name,' ',patientUser.last_name) AS fullname"), 
            DB::raw("CONCAT(doctors.title,' ',doctorUser.first_name,' ',doctorUser.last_name) AS fullnameDoctor"), 
        ];

        $certificates = $certificates->paginate($perPage, $fields, 'items', $page);
         
        $certificates->getCollection()->transform(function ($item) { 
            $item->category = __("item_categories." . $item->category);  
            return $item;
        });
        
        return response()->json(["status" => 1, 'items' => $certificates ]);
    } 

    public function delete(Request $request, $id){ 
        $certificate = Certificate::findOr($id, function () {
            return false;
        });

        if(!$certificate){
            return response()->json(["status" => 0, "message" => __("messages.certificateNotExist")]);
        }

        $validator = Validator::make(request()->all(),[
            'cancellation_reason' => 'required'
        ],[
            'cancellation_reason.required' => __('rules.cancellation_reason_required')
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $certificate->cancellation_reason = $request->input("cancellation_reason");
        $certificate->status = 0;
        $certificate->save(); 

        return response()->json(["status" => 1, "message" => __("messages.certificateDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $certificate = Certificate::findOr($id, function () {
            return false;
        });

        if(!$certificate){
            return response()->json(["status" => 0, "message" => __("messages.certificateNotExist")]);
        }
        
        $certificate->status = 1;
        $certificate->save(); 

        return response()->json(["status" => 1, "message" => __("messages.certificateRestored")]);
    } 

    public function getContent(Request $request, $id){ 
        $certificate = Certificate::findOr($id, function () {
            return false;
        });

        if(!$certificate){
            return response()->json(["status" => 0, "message" => __("messages.certificateNotExist")]);
        }
        
        $content = $certificate->content;
        $title = $certificate->title;
        $expires_at = $certificate->expires_at;
         
        $certificateData = (array)DB::table('certificates as c') 
        ->leftJoin('patients as p', 'c.patient_id', '=', 'p.id')
        ->leftJoin('users as pu', 'p.user_id', '=', 'pu.id') 
        ->leftJoin('doctors as d', 'c.doctor_id', '=', 'd.id')
        ->leftJoin('users as du', 'd.user_id', '=', 'du.id') 
        ->leftJoin('medical_units as mu', 'c.medical_unit_id', '=', 'mu.id') 
        ->select([ 
            DB::raw("CONCAT(pu.first_name, ' ', pu.last_name) AS `\$patient_fullName\$`"),
            'pu.first_name AS $patient_first_name$',
            'pu.last_name AS $patient_last_name$',
            'p.address AS $patient_address$',
            'p.city AS $patient_city$',
            'p.state AS $patient_state$',
            'p.country AS $patient_country$',
            DB::raw("CONCAT(p.address, ', ', p.city, ', ', p.state, ', ', p.country) AS `\$patient_fullAddress\$`"),
            'p.blood_type AS $patient_blood_type$', 
            DB::raw("CONCAT(du.first_name, ' ', du.last_name) AS `\$medical_fullName\$`"),
            'du.first_name AS $medical_first_name$',
            'du.last_name AS $medical_last_name$', 
            'mu.address AS $medical_address$',
            'mu.city AS $medical_city$',
            'mu.state AS $medical_state$',
            'mu.country AS $medical_country$',
            DB::raw("CONCAT(mu.address, ', ', mu.city, ', ', mu.state, ', ', mu.country) AS `\$medical_fullAddress\$`"),
            'd.license AS $medical_license$',
        ])
        ->where('c.id', $id) 
        ->first();
        $logos = Setting::select(['value'])->where("key","logos")->first();
        $logos = $logos ? json_decode($logos->value) : json_decode('{"logo_light":"", "logo_dark":""}');
        
        $logo = $logos->logo_light 
        ? public_path("../resources/img/brand/").$logos->logo_light 
        : public_path('../resources/img/brand/logo_white.svg');

        $content = str_replace(array_keys($certificateData), array_values($certificateData), $content); 
        $pdf = Pdf::loadView('pdf.certificate', compact('certificateData','content','logo', 'title', 'expires_at'));
        
        return $pdf->stream('justificante_medico.pdf'); 
    } 
}



