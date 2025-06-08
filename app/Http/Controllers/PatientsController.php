<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Patient,
    User,
    MedicalHistory,
    Doctor,
};

class PatientsController extends Controller
{ 
    public function list(Request $request){ 
        $patient = Patient::leftJoin('users', 'patients.user_id', '=', 'users.id')
                        ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id') 
                        ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
                        ->whereIn("patients.status", $request->input("status"));
                  
        if(Auth::user()->role == 2){
            $user_id = Doctor::where('user_id',Auth::user()->id)->get()[0]->id;
            $patient->where(function ($query) use ($user_id) {
                $query->where("doctor_id", $user_id);
            });
        }

        if($request->input("s"))
        {
            $patient->where('users.first_name', 'like', $request->input("s") . '%')
                  ->orWhere('users.last_name', 'like', $request->input("s") . '%')
                  ->orWhere('users.email', 'like', $request->input("s") . '%')
                  ->orWhere('users.phone', 'like', $request->input("s") . '%')
                  ->orWhere('patients.address', 'like', $request->input("s") . '%')
                  ->orWhere('patients.city', 'like', $request->input("s") . '%')
                  ->orWhere('patients.country', 'like', $request->input("s") . '%')
                  ->orWhere('patients.state', 'like', $request->input("s") . '%')
                  ->orWhere('patients.blood_type', 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(doctor_user.first_name,' ',doctor_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'like', $request->input("s") . '%');
        }

        if($request->input("role") != ""){
            $patient->where("role",$request->input("role"));
        }

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalPatients = $patient->count();
        $totalPages = ceil($totalPatients / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "patients.id",  
            "users.image", 
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS fullname"), 
            DB::raw("CONCAT(doctors.title,' ',doctor_user.first_name,' ',doctor_user.last_name) AS fullnameDoctor"), 
            "users.email",
            "users.phone",
            "users.role", 
            DB::raw("CONCAT(patients.address,', ',patients.city,', ',patients.zipcode,', ',patients.country) AS fulladdress"),   
            "patients.dob",
            DB::raw('FLOOR(DATEDIFF(CURDATE(), patients.dob) / 365) AS age'),
            "patients.blood_type",
            "users.gender",
            "patients.user_id",
            "users.status", 
            "users.first_name",
            "users.last_name", 
            "doctors.license",
            "doctor_user.gender as doctor_gender",
            "patients.doctor_id"
        ];

        $patient = $patient->paginate($perPage, $fields, 'patients', $page);
         
        return response()->json(["status" => 1, 'items' => $patient ]);
    } 

    public function delete(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.patientNotExist")]);
        }
        
        $user->status = 0;
        $user->patient->status = 0;
        $user->save(); 
        $user->patient->save();

        return response()->json(["status" => 1, "message" => __("messages.patientDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $user = User::findOr($id, function () {
            return false;
        });

        if(!$user){
            return response()->json(["status" => 0, "message" => __("messages.patientNotExist")]);
        }
        
        $user->status = 1; 
        $user->patient->status = 1;
        $user->save(); 
        $user->patient->save();

        return response()->json(["status" => 1, "message" => __("messages.patientRestored")]);
    }

    public function update_record(Request $request, $id){ 
        $rules = [];
        $rulesText = [];
        
        if($request->input("weight")){ 
            $rules['weight'] = ['required'];
            $rulesText['weight.required'] = __('rules.weight_numeric'); 
        }

        if($request->input("height")){ 
            $rules['height'] = ['required'];
            $rulesText['height.required'] = __('rules.height_numeric'); 
        }

        if($request->input("passive_smoking") || $request->input("smoking")){
            $rules['smoking_details'] = ['required'];
            $rulesText['smoking_details.required'] = __('rules.smoking_details_required'); 
        }

        if($request->input("alcohol_usage")){
            $rules['alcohol_details'] = ['required'];
            $rulesText['alcohol_details.required'] = __('rules.alcohol_details_required'); 
        }

        if($request->input("has_allergies")){
            $rules['allergies_details'] = ['required'];
            $rulesText['allergies_details.required'] = __('rules.allergies_details_required'); 
        }

        if($request->input("has_allergies")){
            $rules['allergies_details'] = ['required'];
            $rulesText['allergies_details.required'] = __('rules.allergies_details_required'); 
        }

        if($request->input("has_surgeries")){
            $rules['surgery_details'] = ['required'];
            $rulesText['surgery_details.required'] = __('rules.surgery_details_required'); 
        }

        if($request->input("drug_usage")){
            $rules['drug_details'] = ['required'];
            $rules['last_drug_usage'] = ['required'];
            $rulesText['drug_details.required'] = __('rules.drug_details_required'); 
            $rulesText['last_drug_usage.required'] = __('rules.last_drug_usage_required'); 
        }

        if($request->input("urinary_incontinence")){
            $rules['urinary_incontinence_details'] = ['required'];
            $rulesText['urinary_incontinence_details.required'] = __('rules.urinary_incontinence_details_required'); 
        }

        if($request->input("has_family_diseases")){
            $rules['family_diseases_details'] = ['required'];
            $rulesText['family_diseases_details.required'] = __('rules.family_diseases_details_required'); 
        }

        if($request->input("has_vih_test")){
            $rules['vih_last_test_date'] = ['required'];
            $rules['vih_result'] = ['required'];
            $rulesText['vih_last_test_date.required'] = __('rules.vih_last_test_date_required'); 
            $rulesText['vih_result.required'] = __('rules.vih_result_required'); 
        }

        if($request->input("has_insurance")){
            $rules['insurance_name'] = ['required'];
            $rules['insurance_id'] = ['required'];
            $rulesText['insurance_name.required'] = __('rules.insurance_name_required'); 
            $rulesText['insurance_id.required'] = __('rules.insurance_id_required'); 
        }

        if($request->input("has_family_diseases")){
            $rules['family_diseases_details'] = ['required'];
            $rulesText['family_diseases_details.required'] = __('rules.family_diseases_details_required'); 
        }

        if($request->input("has_family_diseases")){
            $rules['family_diseases_details'] = ['required'];
            $rulesText['family_diseases_details.required'] = __('rules.family_diseases_details_required'); 
        }

        if($request->input("has_had_sex")){
            $rules['last_sex_with_other'] = ['required'];
            $rules['sexual_start_age'] = ['numeric'];
            $rules['sexual_partners_count'] = ['numeric'];

            $rulesText['last_sex_with_other.required'] = __('rules.last_sex_with_other_required'); 
            $rulesText['sexual_start_age.numeric'] = __('rules.sexual_start_age_numeric');
            $rulesText['sexual_partners_count.numeric'] = __('rules.sexual_partners_count_numeric');
        }

        if($request->input("sexual_pain")){
            $rules['sexual_pain_frequency'] = ['required'];
            $rulesText['sexual_pain_frequency.required'] = __('rules.sexual_pain_frequency_required'); 
        }

        if($request->input("metrorrhagia")){
            $rules['metrorrhagia_detail'] = ['required'];
            $rulesText['metrorrhagia_detail.required'] = __('rules.metrorrhagia_detail_required'); 
        }

        if($request->input("leukorrhea")){
            $rules['leukorrhea_detail'] = ['required'];
            $rulesText['leukorrhea_detail.required'] = __('rules.leukorrhea_detail_required'); 
        }

        if($request->input("pruritus")){
            $rules['pruritus_detail'] = ['required'];
            $rulesText['pruritus_detail.required'] = __('rules.pruritus_detail_required'); 
        }

        if($request->input("urinary_incontinence_treatement")){
            $rules['urinary_incontinence_treatement_detail'] = ['required'];
            $rulesText['urinary_incontinence_treatement_detail.required'] = __('rules.urinary_incontinence_treatement_details_required'); 
        }

        if($request->input("has_blood_transfusion")){ 
            $rules['last_blood_transfusion'] = ['required'];
            $rulesText['last_blood_transfusion.required'] = __('rules.last_blood_transfusions_required');
        }

        $validator = Validator::make(request()->all(),$rules,$rulesText);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $medicalHistory = MedicalHistory::findOr($id, function () {
            return false;
        });

        $medicalHistory->marital_status = $request->input("marital_status");
        $medicalHistory->occupation = $request->input("occupation");
        $medicalHistory->spouse_occupation = $request->input("spouse_occupation");
        $medicalHistory->religion = $request->input("religion");
        $medicalHistory->height = $request->input("height");
        $medicalHistory->weight = $request->input("weight");
        $medicalHistory->has_blood_transfusion = $request->input("has_blood_transfusion") ? $request->input("has_blood_transfusion") : 0; 
        $medicalHistory->last_blood_transfusion = $request->input("last_blood_transfusion");
        $medicalHistory->smoking = $request->input("smoking")  ? $request->input("smoking") : 0; 
        $medicalHistory->passive_smoking = $request->input("passive_smoking") ? $request->input("passive_smoking") : 0; 
        $medicalHistory->smoking_details = $request->input("smoking_details");
        $medicalHistory->alcohol_usage = $request->input("alcohol_usage") ? $request->input("alcohol_usage") : 0; 
        $medicalHistory->alcohol_details = $request->input("alcohol_details");
        $medicalHistory->has_allergies = $request->input("has_allergies") ? $request->input("has_allergies") : 0; 
        $medicalHistory->allergies_details = $request->input("allergies_details");
        $medicalHistory->has_surgeries = $request->input("has_surgeries") ? $request->input("has_surgeries") : 0; 
        $medicalHistory->surgery_details = $request->input("surgery_details");
        $medicalHistory->drug_usage = $request->input("drug_usage") ? $request->input("drug_usage") : 0; 
        $medicalHistory->drug_details = $request->input("drug_details");
        $medicalHistory->last_drug_usage = $request->input("last_drug_usage");
        $medicalHistory->urinary_incontinence = $request->input("urinary_incontinence") ? $request->input("urinary_incontinence") : 0; 
        $medicalHistory->urinary_incontinence_details = $request->input("urinary_incontinence_details");
        $medicalHistory->has_family_diseases = $request->input("has_family_diseases") ? $request->input("has_family_diseases") : 0; 
        $medicalHistory->family_diseases_details = $request->input("family_diseases_details");
        $medicalHistory->has_vih_test = $request->input("has_vih_test") ? $request->input("has_vih_test") : 0; 
        $medicalHistory->vih_last_test_date = $request->input("vih_last_test_date");
        $medicalHistory->vih_result = $request->input("vih_result");
        $medicalHistory->has_insurance = $request->input("has_insurance") ? $request->input("has_insurance") : 0; 
        $medicalHistory->insurance_name = $request->input("insurance_name");
        $medicalHistory->insurance_id = $request->input("insurance_id");
        $medicalHistory->has_had_sex = $request->input("has_had_sex") ? $request->input("has_had_sex") : 0; 
        $medicalHistory->has_stable_partner = $request->input("has_stable_partner") ? $request->input("has_stable_partner") : 0; 
        $medicalHistory->last_sex_with_partner = $request->input("last_sex_with_partner");
        $medicalHistory->last_sex_with_other = $request->input("last_sex_with_other");
        $medicalHistory->sexual_start_age = $request->input("sexual_start_age");
        $medicalHistory->sexual_partners_count = $request->input("sexual_partners_count");
        $medicalHistory->pathological_history = $request->input("pathological_history");
        $medicalHistory->other_non_pathological_history = $request->input("other_non_pathological_history");
        $medicalHistory->family_cancer_history = $request->input("family_cancer_history");
        $medicalHistory->condom_usage = $request->input("condom_usage") ? $request->input("condom_usage") : 0;
        $medicalHistory->sexual_pain = $request->input("sexual_pain") ? $request->input("sexual_pain") : 0;
        $medicalHistory->sexual_discomfort = $request->input("sexual_discomfort") ? $request->input("sexual_discomfort") : 0;
        $medicalHistory->sexual_sensibility = $request->input("sexual_sensibility") ? $request->input("sexual_sensibility") : 0;
        $medicalHistory->sexual_dryness = $request->input("sexual_dryness") ? $request->input("sexual_dryness") : 0;
        $medicalHistory->sexual_pain_frequency = $request->input("sexual_pain_frequency");
        $medicalHistory->metrorrhagia = $request->input("metrorrhagia") ? $request->input("metrorrhagia") : 0;
        $medicalHistory->metrorrhagia_detail = $request->input("metrorrhagia_detail");
        $medicalHistory->leukorrhea = $request->input("leukorrhea") ? $request->input("leukorrhea") : 0; 
        $medicalHistory->leukorrhea_detail = $request->input("leukorrhea_detail");
        $medicalHistory->pruritus = $request->input("pruritus") ? $request->input("pruritus") : 0; 
        $medicalHistory->pruritus_detail = $request->input("pruritus_detail");
        $medicalHistory->menstrual_rhythm = $request->input("menstrual_rhythm");
        $medicalHistory->last_menstrual = $request->input("last_menstrual");
        $medicalHistory->urinary_incontinence_treatement = $request->input("urinary_incontinence_treatement") ? $request->input("urinary_incontinence_treatement") : 0; 
        $medicalHistory->urinary_incontinence_treatement_detail = $request->input("urinary_incontinence_treatement_detail");
        $medicalHistory->menarche = $request->input("menarche");
        $medicalHistory->gynecological_history = $request->input("gynecological_history");
        $medicalHistory->gestation = $request->input("gestation", 0);
        $medicalHistory->birth = $request->input("birth", 0);
        $medicalHistory->abortion =  $request->input("abortion", 0);
        $medicalHistory->cesarean =  $request->input("cesarean", 0);
        
        $medicalHistory->save();

        return response()->json(["status" => 1, "message" => __("messages.medicalRecordUpdated")]);
    }
}



