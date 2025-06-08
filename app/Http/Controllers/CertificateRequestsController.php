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
};
use App\Models\{
    CertificateRequest, 
    Doctor,
    User,
    Patient,
}; 
use App\Jobs\{
    SendRequestCreatedEmail, 
    SendRequestCancelEmail,
};
use App\Notifications\UserNotification; 

class CertificateRequestsController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'type' => 'required',   
        ],
        [
            'type.required' => __('rules.type_required'),   
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $certificateRequest = new CertificateRequest;
         
        $certificateRequest->type = $request->input("type"); 
        $certificateRequest->notes = $request->input("notes");  
        $certificateRequest->doctor_id = $request->input("doctor_id");
        $certificateRequest->patient_id = Auth::user()->patient->id;

        $certificateRequest->save(); 
         
        SendRequestCreatedEmail::dispatch($certificateRequest); 
        $types = [
            1 => "messages.medicalCertificate",
            2 => "messages.certificate",
            3 => "messages.recipe",
        ];
        $patient = User::find(Patient::find($certificateRequest->patient_id)->user_id);
        $doctor = Doctor::find($certificateRequest->doctor_id);
        $user = User::find($doctor->user_id);
        $user->notify(new UserNotification(
            "notifications.newRequest",
            "notifications.newRequestDoctor",
            [
                'patientFullName' => $patient->first_name." ".$patient->last_name,   
                'typeDocument' => $types[$certificateRequest->type]
            ],
            '/dashboard/requests?request='.$certificateRequest->id,
            'requests',
            $certificateRequest->id,
            "info",
        ));

        return response()->json(["status" => 1, "message" => __("messages.certificateRequestCreated")]);
    } 

    public function list(Request $request){ 
        $certificateRequest = CertificateRequest::leftJoin('patients', 'certificate_requests.patient_id', '=', 'patients.id')
                                                ->leftJoin('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
                                                ->leftJoin('doctors', 'certificate_requests.doctor_id', '=', 'doctors.id')
                                                ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
                                                ->whereIn("certificate_requests.status", $request->input("status"));

        if($request->input("s")){
            $search = $request->input("s");
        
            $certificateRequest->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name)"), 'like', $search.'%')
                    ->orWhere("certificate_requests.notes", 'like', $search.'%')
                    ->orWhere("certificate_requests.id", '=', $search);
            });
        }

        if(Auth::user()->role == 2){
            $doctor_id = Doctor::where('user_id',Auth::user()->id)->get()[0]->id;
            $certificateRequest->where(function ($query) use ($doctor_id) {
                $query->where("certificate_requests.doctor_id", $doctor_id);
            });
        }
         
        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalCertificateRequest = $certificateRequest->count();
        $totalPages = ceil($totalCertificateRequest / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name) AS patient"), 
            DB::raw("CONCAT(doctor_user.first_name,' ',doctor_user.last_name) AS doctor"), 
            "patient_user.image",
            "certificate_requests.id",
            "certificate_requests.type",  
            "certificate_requests.notes", 
            "certificate_requests.status", 
            "certificate_requests.rejection_reason",
            "certificate_requests.certificate_id",
        ];

        $certificateRequest = $certificateRequest->paginate($perPage, $fields, 'certificate_requests', $page); 
        
        return response()->json(["status" => 1, 'items' => $certificateRequest ]);
    } 

    public function delete(Request $request, $id){ 
        $certificateRequest = CertificateRequest::findOr($id, function () {
            return false;
        });

        if(!$certificateRequest){
            return response()->json(["status" => 0, "message" => __("messages.certificateRequestNotExist")]);
        }
        
        $validator = Validator::make(request()->all(),[
            'cancellation_reason' => 'required'
        ],[
            'cancellation_reason.required' => __('rules.cancellation_reason_required')
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $certificateRequest->status = 0;
        $certificateRequest->rejection_reason = $request->input("cancellation_reason");
        $certificateRequest->save(); 

        SendRequestCancelEmail::dispatch($certificateRequest);

        return response()->json(["status" => 1, "message" => __("messages.certificateRequestDelete")]);
    }  
}



