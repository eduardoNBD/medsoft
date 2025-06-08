<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{
    Hash,
    Validator, 
    Mail,
    Lang,
    DB,
    Auth,
    Storage,
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
    Setting,
    ItemReload
}; 

class EncountersController extends Controller
{
    public function create(Request $request){  
        $rules = [
            'doctor' => 'required', 
            'medical_unit' => 'required',
            'subject' => 'required',
        ];
        
        $rulesText = [ 
            'doctor.required' => __('rules.doctor_required'),  
            'medical_unit.required' => __('rules.medical_unit_required'), 
            'subject.required' => __('rules.subject_required'), 
        ];
        
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
 
        $encounter = new Encounter; 
        $encounter->medical_unit_id = $request->input("medical_unit");
        $encounter->patient_id = $request->input("patient");
        $encounter->doctor_id = $request->input("doctor");
        $encounter->date = date("Y-m-d H:i:s");
        $encounter->status = 1;
        $encounter->items = "[]";
        $encounter->diagnosis = "";
        $encounter->subtotal = str_replace('"',"",Setting::firstWhere('key', $request->input("subject"))->value);     
        $encounter->discount = $request->input("discount") ? $request->input("discount") : 0; 
        $encounter->subject = $request->input("subject"); 
        $encounter->addictions = $request->input("addictions") ? 1 : 0;
        $encounter->addictions_text = $request->input("addictions_text");
        $encounter->allergies = $request->input("allergies") ? 1 : 0;
        $encounter->allergies_text = $request->input("allergies_text");
        $encounter->surgeries = $request->input("surgeries") ? 1 : 0;
        $encounter->surgeries_text = $request->input("surgeries_text");
        $encounter->medications = $request->input("medications") ? 1 : 0;
        $encounter->medications_text = $request->input("medications_text");
        $encounter->patient_dob = $request->input("dob");
        $encounter->patient_gender = $request->input("gender");
        $encounter->patient_first_name = $request->input("first_name");
        $encounter->patient_last_name = $request->input("last_name");
        $encounter->patient_email = $request->input("email");
        $encounter->patient_phone = $request->input("phone");
        $encounter->patient_language = $request->input("language");
        $encounter->patient_blood_type = $request->input("bloodType"); 
        $encounter->treatment = "";
        $encounter->files = "[]";
        $encounter->created_by = Auth::user()->id;
        $encounter->commission_amount = $doctor->commission_amount;
        
        $encounter->save();
        
        return response()->json(["status" => 1, "message" => __("messages.encounterCreated")."... ".__("messages.redirecting"), "id" => $encounter->id]);
    }  

    public function update(Request $request,$id){  
        $rules = [ 'medical_unit' => 'required'];
        $rulesText = [  'medical_unit.required' => __('rules.medical_unit_required'), ];
        
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

        $encounter = Encounter::findOr($id, function () {
            return false;
        });

        if(!$encounter){
            return response()->json(["status" => 0, "message" => __("messages.encounterNotExist")]);
        } 

        $doctor = Doctor::findOr($encounter->doctor_id, function () {
            return false;
        });

        if(!$doctor){
            return response()->json(["status" => 0, "message" => __("messages.doctorNotExist")]);
        }  
 
        $encounter->medical_unit_id = $request->input("medical_unit");  
        $encounter->subtotal = str_replace('"',"",Setting::firstWhere('key', $request->input("subject"))->value);     
        $encounter->discount = $request->input("discount") ? $request->input("discount") : 0; 
        $encounter->subject = $request->input("subject"); 
        $encounter->addictions = $request->input("addictions") ? 1 : 0;
        $encounter->addictions_text = $request->input("addictions_text");
        $encounter->allergies = $request->input("allergies") ? 1 : 0;
        $encounter->allergies_text = $request->input("allergies_text");
        $encounter->surgeries = $request->input("surgeries") ? 1 : 0;
        $encounter->surgeries_text = $request->input("surgeries_text");
        $encounter->medications = $request->input("medications") ? 1 : 0;
        $encounter->medications_text = $request->input("medications_text");
        $encounter->patient_dob = $request->input("dob");
        $encounter->patient_gender = $request->input("gender");
        $encounter->patient_first_name = $request->input("first_name");
        $encounter->patient_last_name = $request->input("last_name");
        $encounter->patient_email = $request->input("email");
        $encounter->patient_phone = $request->input("phone");
        $encounter->patient_language = $request->input("language");
        $encounter->patient_blood_type = $request->input("bloodType");   
        
        $encounter->save();
        
        return response()->json(["status" => 1, "message" => __("messages.encounterUpdate")."... ".__("messages.redirecting"), "id" => $encounter->id]);
    }  

    public function updateDetail(Request $request, $id) {   
        $encounter = Encounter::findOr($id, function () {
            return false;
        });
    
        $existingFiles = json_decode($encounter->files, true) ?? [];  
        $filesHeader = $request->input("filesHeader", []); 
        $newFiles = $request->file('files');  
        
        foreach ($existingFiles as $key => $file) {
            if (isset($filesHeader[$key])) {
                $existingFiles[$key]['header'] = $filesHeader[$key];
            }
        }
     
        if ($newFiles) {
            foreach ($newFiles as $index => $newFile) { 
                if ($newFile && $newFile->isValid()) {
                
                    $filePath = $newFile->store("encounters/$id", 'public');
                    
                    $existingFiles[] = [
                        'path' => $filePath,
                        'type' => $newFile->getMimeType(), 
                        'header' => $filesHeader[$index],
                    ];
                }
            }
        } 
        
        $current_items = json_decode($encounter->items); 

        foreach ($current_items as $key => $item) {
            if($item->type == "supply"){
                $reload = ItemReload::find($item->item_reload_id);
                $reload->remaining+= $item->qty;

                $reload->save();
            }
        }
        
        $new_items = json_decode($request->input("items")); 
        
        foreach ($new_items as $key => $item) {
            if($item->type == "supply"){
                $reload = ItemReload::find($item->item_reload_id);
                $reload->remaining-= $item->qty;

                $reload->save();
            }
        }

        $encounter->items = $request->input("items");
        $encounter->total = $request->input("total");
        $encounter->diagnosis = $request->input("diagnosis") ? $request->input("diagnosis") : "";
        $encounter->discount = $request->input("discount") ? $request->input("discount")  : 0;
        $encounter->notes = $request->input("notes");
        $encounter->payment_method = $request->input("payment_method");
        $encounter->treatment = $request->input("treatment") ? $request->input('treatment') : "";
        $encounter->files = json_encode($existingFiles);
    
        $encounter->save();
    
        return response()->json(["status" => 1, "message" => __("messages.encounterUpdate")]);
    }

    public function pay(Request $request, $id){ 
        $validator = Validator::make(request()->all(), [
            'payment_method' => 'required',
            'diagnosis' => 'required',
            'treatment' => 'required',
        ],[
            'payment_method.required' => __('rules.payment_method_required'), 
            'diagnosis.required' => __('rules.diagnosis_required'), 
            'treatment.required' => __('rules.treatment_required'), 
        ]);
      
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }

        $encounter = Encounter::findOr($id, function () {
            return false;
        });

        $existingFiles = json_decode($encounter->files, true) ?? [];  
        $filesHeader = $request->input("filesHeader", []); 
        $newFiles = $request->file('files');  
        
        foreach ($existingFiles as $key => $file) {
            if (isset($filesHeader[$key])) {
                $existingFiles[$key]['header'] = $filesHeader[$key];
            }
        }
     
        if ($newFiles) {
            foreach ($newFiles as $index => $newFile) { 
                if ($newFile && $newFile->isValid()) {
                
                    $filePath = $newFile->store("encounters/$id", 'public');
                    
                    $existingFiles[] = [
                        'path' => $filePath,
                        'type' => $newFile->getMimeType(), 
                        'header' => $filesHeader[$index],
                    ];
                }
            }
        } 

        $current_items = json_decode($encounter->items); 

        foreach ($current_items as $key => $item) {
            if($item->type == "supply"){
                $reload = ItemReload::find($item->item_reload_id);
                $reload->remaining+= $item->qty;

                $reload->save();
            }
        }
        
        $new_items = json_decode($request->input("items")); 
        
        foreach ($new_items as $key => $item) {
            if($item->type == "supply"){
                $reload = ItemReload::find($item->item_reload_id);
                $reload->remaining-= $item->qty;

                $reload->save();
            }
        }

        $encounter->items = $request->input("items");
        $encounter->total = $request->input("total");
        $encounter->diagnosis = $request->input("diagnosis") ? $request->input("diagnosis") : "";
        $encounter->discount = $request->input("discount");
        $encounter->notes = $request->input("notes");
        $encounter->payment_method = $request->input("payment_method");
        $encounter->treatment = $request->input("treatment");
        $encounter->files = json_encode($existingFiles);
        $encounter->status = 2;

        $encounter->save();

        return response()->json(["status" => 1, "message" => __("messages.encounterPayed")]);
    }

    public function delete(Request $request, $id){ 
        $encounter = Encounter::findOr($id, function () {
            return false;
        });

        if(!$encounter){
            return response()->json(["status" => 0, "message" => __("messages.encounterNotExist")]);
        }
        
        $validator = Validator::make(request()->all(),[
            'cancellation_reason' => 'required'
        ],[
            'cancellation_reason.required' => __('rules.cancellation_reason_required')
        ]);

        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }
        
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

        return response()->json(["status" => 1, "message" => __("messages.encounterDelete")]);
    } 

    public function deleteFile(Request $request, $id){ 
        $encounter = Encounter::findOr($id, function () {
            return false;
        });
        $filePath = $request->input('path');
        $files    = json_decode($encounter->files, true);

        if (Storage::disk('public')->exists($filePath)) {
            
            Storage::disk('public')->delete($filePath);
            
            $files = array_filter($files, function ($file) use ($filePath) {
                return $file['path'] !== $filePath;
            });

            $encounter->files = json_encode(array_values($files));  
            $encounter->save();

            return response()->json(["status" => 1, "message" => __("messages.fileDeleted")]);
        }
    }

    public function list(Request $request){ 
        $encounters = Encounter::leftJoin('doctors', 'encounters.doctor_id', '=', 'doctors.id')
                                   ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
                                   ->leftJoin('patients', 'encounters.patient_id', '=', 'patients.id')
                                   ->leftJoin('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
                                   ->whereIn("encounters.status", $request->input("status"))
                                   ->orderBy('encounters.date', 'asc');  

        if($request->input("s"))
        {
            $encounters->where(DB::raw("CONCAT(doctors.title,' ',doctor_user.first_name,' ',doctor_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(doctor_user.first_name,' ',doctor_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere(DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name)"), 'like', $request->input("s") . '%')
                  ->orWhere('subject', 'like', $request->input("s") . '%');
        }

        if(Auth::user()->role == 2){
            $user_id = Doctor::where('user_id',Auth::user()->id)->get()[0]->id;
            $encounters->where(function ($query) use ($user_id) {
                $query->where("patients.doctor_id", $user_id);
            });
        }

        if(Auth::user()->role == 3){
            $user_id = Patient::where('user_id',Auth::user()->id)->get()[0]->id;
            $encounters->where(function ($query) use ($user_id) {
                $query->where("patients.id", $user_id);
            });
        }

        if($request->input("role") != ""){
            $encounters->where("role",$request->input("role"));
        }

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalEncounters = $encounters->count();
        $totalPages = ceil($totalEncounters / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "encounters.id",  
            DB::raw("CONCAT(COALESCE(doctors.title, ''), ' ', COALESCE(doctor_user.first_name, ''), ' ', COALESCE(doctor_user.last_name, '')) AS fullnameDoctor"),
            DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name) AS fullnamePatient"), 
            "encounters.patient_email",
            "encounters.patient_phone",  
            "encounters.subtotal", 
            "encounters.patient_dob",
            "encounters.patient_blood_type", 
            "encounters.date",
            "encounters.status", 
            "encounters.discount",
            "encounters.subject",
            "encounters.items", 
            "doctor_user.first_name",
        ];

        $encounters = $encounters->paginate($perPage, $fields, 'encounters', $page);
        
        $encounters->getCollection()->transform(function ($item) { 
            $item->subject = __("subjects." . $item->subject); //  
            $items = json_decode($item->items);
            $item->subtotalItems  = array_reduce($items, function ($carry, $obj) {
                return $carry + (float)$obj->price * (int)$obj->qty;
            }, 0);
            return $item;
        });

        return response()->json(["status" => 1, 'items' => $encounters ]);
    } 

    public function fileList(Request $request, $id)
    { 
        $encounters = Encounter::whereIn("encounters.status", [1,2])->where(["patient_id" => $id ])->orderBy("created_at", "desc")->get();

        // Recolectar todos los archivos subidos
        $files = collect();

        foreach ($encounters as $encounter) {
            // Decodificar el JSON de archivos
            $encounterFiles = json_decode($encounter->files, true);
            if ($encounterFiles) {
                foreach ($encounterFiles as $file) {
                    $file['encounter_id'] = $encounter->id;
                    $file['encounter_date'] = $encounter->date;  // Agregar el ID del encounter
                    $files->push($file);  // Agregar archivo a la colección
                }
            }
        }

        $perPage = 5; // Cambia según lo que necesites
        $page = request()->input('page', 1);
        $totalFiles = $files->count();
        $totalPages = ceil($totalFiles / $perPage);
 
        $paginatedFiles = $files->forPage($page, $perPage)->values();

        return response()->json([
            "status" => 1,
            "items" => $paginatedFiles,
            "pagination" => [
                "total_items" => $totalFiles,
                "per_page" => $perPage,
                "current_page" => $page,
                "total_pages" => $totalPages,
            ],
        ]);
    }

    public function diagnosisList(Request $request, $id){ 
        $encounters = Encounter::whereIn("encounters.status", [1,2])
                            ->where(["patient_id" => $id ])
                            ->where($request->input("type"),"!=", ""); 

        $perPage = 5; 
        $page = $request->input("page") ?: 1; 
    
        $totalEncounters = $encounters->count();
        $totalPages = ceil($totalEncounters / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "encounters.id",   
            "encounters.treatment",
            "encounters.diagnosis", 
            "encounters.notes", 
            "encounters.date",
        ];

        $encounters = $encounters->paginate($perPage, $fields, 'encounters', $page);

        return response()->json(["status" => 1, 'items' => $encounters ]);
    }

    public function items(Request $request, $id)
{
    // Obtener el tipo de ítem (supply o service) desde el request
    $type = $request->input("type");

    // Validar que el tipo sea válido
    $allowedTypes = ['supply', 'service'];
    if ($type && !in_array($type, $allowedTypes)) {
        return response()->json(["status" => 0, "message" => "Invalid type parameter"], 400);
    }

    // Configuración de paginación
    $perPage = $request->input("per_page", 5); 
    $page = $request->input("page", 1); 

    // Consulta base para obtener los encuentros del paciente, ordenados por created_at
    $encounters = Encounter::whereNotNull('items')
        ->where("patient_id", $id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Procesar los ítems
    $items = $encounters->flatMap(function ($encounter) use ($type) {
        $items = json_decode($encounter->items, true);
        return collect($items)
            ->when($type, fn($collection) => $collection->where('type', $type)) // Filtrar por tipo si se especifica
            ->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'qty' => (int) $item['qty'],
                    'price' => (float) $item['price'],
                    'total_price' => (int) $item['qty'] * (float) $item['price'], // Precio total por ítem
                ];
            });
    });

    // Contar el número total de ítems
    $totalItems = $items->count();
    $totalPages = ceil($totalItems / $perPage);

    // Aplicar paginación manual
    $paginatedItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

    // Respuesta JSON con los resultados
    return response()->json([
        "status" => 1,
        "items" => $paginatedItems,
        "pagination" => [
            "total_items" => $totalItems,
            "per_page" => $perPage,
            "current_page" => $page,
            "total_pages" => $totalPages,
        ],
    ]);
}
}



