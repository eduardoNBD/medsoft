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
    User,
    Specialty,
    Patient,
    Doctor,
    Appointment,
    Item,
    ItemCategory,
    Encounter,
    MedicalHistory,
    MedicalUnit,
    Setting,
    Template,
    AreaCategory,
    Expense,
    ExpenseRecord,
    Certificate,
    ItemReloads,
    CertificateRequest,
};

use Carbon\Carbon;

class DashboardController extends Controller{
    
    public function index(){  
        $patients = Patient::join('users', 'patients.user_id', '=', 'users.id')
                            ->select(
                                'patients.id as patient_id',
                                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fullname"),
                                'users.email',
                                'users.phone',
                                DB::raw("DATE_FORMAT(patients.dob, '%d/%m/%Y') AS dob"), // Formato d/m/Y
                                'patients.created_at'
                            );
        
        if(Auth::user()->role == 2){
            $patients = $patients->where("patients.doctor_id",Auth::user()->doctor->id); 
        }

        $patients = $patients->orderBy('patients.created_at', 'desc')->limit(5)->get()->map(function ($patient) {
                            return [
                                'fullname' => "<strong>{$patient->fullname}</strong>",
                                'email' => "<a class='block' href='mailto:{$patient->email}'><small>{$patient->email}</small></a>
                                            <a class='block' href='tel:{$patient->phone}'><small>{$patient->phone}</small></a>",
                                'dob' => "<small>{$patient->dob}</small>",
                                'created_at' => "<small>{$patient->created_at->format('d/m/Y H:i')}</small>",
                            ];
                        });
                        
        $doctors = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
                            ->select(
                                'doctors.id as doctor_id',
                                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fullname"),
                                'users.email',
                                'users.phone',
                                'doctors.license',
                                'doctors.created_at'
                            )
                            ->orderBy('doctors.created_at', 'desc')
                            ->limit(5)
                            ->get()
                            ->map(function ($doctor) {
                                return [
                                    'fullname' => "<strong>{$doctor->fullname}</strong>",
                                    'email' => "<a class='block' href='mailto:{$doctor->email}'><small>{$doctor->email}</small></a>
                                                <a class='block' href='tel:{$doctor->phone}'><small>{$doctor->phone}</small></a>",
                                    'license' => "<small>{$doctor->license}</small>",
                                    'created_at' => "<small>{$doctor->created_at->format('d/m/Y H:i')}</small>",
                                ];
                            });

        $totalApp     = Appointment::whereDate('date', Carbon::today());
        $pendingApp   = Appointment::whereDate('date', Carbon::today())->whereIn("status",[1,2]);
        $completeApp  = Appointment::whereDate('date', Carbon::today())->where("status",3);
        $topSupplies  = Encounter::whereNotNull('items');
        $topServices  = Encounter::whereNotNull('items');
        $tPatients    = new Patient;
        $tDoctors     = new Doctor;
        $tSupplies    = Item::where("type","supply"); 
        $tServices    = Item::where("type","service");
        $tAppointment = Appointment::where("status","!=",0);
        $tEncounters  = Encounter::where("status","!=",0);

        if(Auth::user()->role == 2){  
            $medicalUnits = json_decode(Auth::user()->doctor->medical_units, true); 
            
            $totalApp = $totalApp->where("doctor_id",Auth::user()->doctor->id); 
            $pendingApp = $pendingApp->where("doctor_id",Auth::user()->doctor->id); 
            $completeApp = $completeApp->where("doctor_id",Auth::user()->doctor->id); 
            $topSupplies = $topSupplies->where("doctor_id",Auth::user()->doctor->id); 
            $topServices = $topServices->where("doctor_id",Auth::user()->doctor->id);    
            $tSupplies = $tSupplies->whereIn('items.medical_unit_id', $medicalUnits); 
            $tServices = $tServices->whereIn('items.medical_unit_id', $medicalUnits); 
            $tPatients = $tPatients->where("doctor_id",Auth::user()->doctor->id); 
            $tAppointment = $tAppointment->where("doctor_id",Auth::user()->doctor->id); 
            $tEncounters = $tEncounters->where("doctor_id",Auth::user()->doctor->id); 
        }

        if(Auth::user()->role == 3){
            $totalApp = $totalApp->where("patient_id",Auth::user()->patient->id); 
            $pendingApp = $pendingApp->where("patient_id",Auth::user()->patient->id); 
            $completeApp = $completeApp->where("patient_id",Auth::user()->patient->id); 
            $topSupplies = $topSupplies->where("patient_id",Auth::user()->patient->id); 
            $topServices = $topServices->where("patient_id",Auth::user()->patient->id); 
        }

        $totalApp = $totalApp->count();
        $pendingApp = $pendingApp->count();
        $completeApp = $completeApp->count();
        
        $topSupplies = $topSupplies->get()
            ->flatMap(function ($encounter) {
                $items = json_decode($encounter->items, true);
                return collect($items)
                    ->where('type', 'supply')
                    ->map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'qty' => (int) $item['qty'],
                        ];
                    });
            })
            ->groupBy('id')
            ->map(function ($items, $id) {
                return [
                    'name' => $items->first()['name'],
                    'total_qty' => $items->sum('qty'),
                ];
            })
            ->sortByDesc('total_qty')
            ->take(5);
            
        $topServices = $topServices->get()
            ->flatMap(function ($encounter) {
                $items = json_decode($encounter->items, true);
                return collect($items)
                    ->where('type', 'service')
                    ->map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'qty' => (int) $item['qty'],
                        ];
                    });
            })
            ->groupBy('id')
            ->map(function ($items, $id) {
                return [
                    'name' => $items->first()['name'],
                    'total_qty' => $items->sum('qty'),
                ];
            })
            ->sortByDesc('total_qty')
            ->take(5); // Tomar los 5 más vendidos

        return view("dashboard.home",[
            'patients' => $patients,
            'doctors' => $doctors,
            'totalApp' => $totalApp,
            'pendingApp' => $pendingApp,
            'completeApp' => $completeApp,
            'topSupplies' => $topSupplies,
            'topServices' => $topServices,
            'tPatients' => $tPatients->count(),
            'tDoctors' => $tDoctors->count(),
            'tSupplies' => $tSupplies->count(), 
            'tServices' => $tServices->count(),
            'tAppointment' => $tAppointment->count(),
            'tEncounters' => $tEncounters->count(),
         ]);
    }

    public function medical_units($page = 1){   
        return view("dashboard.medical_units",[
            'page' => $page,   
        ]);
    } 

    public function medical_unit($id = null){
        $title = $id ? "routes.update_medical_unit" : "routes.create_medical_unit";
        $medicalUnit = new MedicalUnit;   
        
        if($id){ 
            $medicalUnit = MedicalUnit::findOr($id, function () {
                return false;
            });
            
            if(!$medicalUnit){
                return redirect('/dashboard/medical_units/?msg='.__("messages.medicalUnitNotExist")."_error");
            }

            if($medicalUnit->status == 0){
                return redirect('/dashboard/medical_units/?msg='.__("messages.medicalUnitDeleted")."_error");
            } 
        }  

        return view("dashboard.medical_unit", [
            'title' => $title,  
            'id' => $id,   
            'medicalUnit' => $medicalUnit
        ]);
    } 

    public function services($page = 1){   
        $categories = ItemCategory::select(["id","name"])->get();

        return view("dashboard.services",[
            'page' => $page,  
            'categories' => $categories,     
        ]);
    } 

    public function service($id = null){
        $title = $id ? "routes.update_service" : "routes.create_service";
        $service = new Item;   
        
        if($id){ 
            $service = Item::findOr($id, function () {
                return false;
            });
            
            if(!$service){
                return redirect('/dashboard/services/?msg='.__("messages.serviceNotExist")."_error");
            }

            if($service->status == 0){
                return redirect('/dashboard/services/?msg='.__("messages.serviceDeleted")."_error");
            } 
        }  

        if(!$service->medical_unit){
            $service->medical_unit = new MedicalUnit; 
        } 

        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $categories = ItemCategory::select(["id","name"])->get();
        $areas      = AreaCategory::select(["id","name"])->get();

        return view("dashboard.service", [
            'title' => $title, 
            'service' => $service,
            'medicalUnits' => $medicalUnits,
            'categories' => $categories,
            'areas' => $areas,
            'id' => $id,   
        ]);
    } 

    public function supplies($page = 1){   
        $categories = ItemCategory::select(["id","name"])->get();

        return view("dashboard.supplies",[
            'page' => $page,  
            'categories' => $categories,     
        ]);
    } 

    public function supply($id = null){
        $title = $id ? "routes.update_supply" : "routes.create_supply";
        $supply = new Item;   
        
        if($id){ 
            $supply = Item::findOr($id, function () {
                return false;
            });
            
            if(!$supply){
                return redirect('/dashboard/supplies/?msg='.__("messages.supplyNotExist")."_error");
            }

            if($supply->status == 0){
                return redirect('/dashboard/supplies/?msg='.__("messages.supplyDeleted")."_error");
            } 
        }  

        if(!$supply->medical_unit){
            $supply->medical_unit = new MedicalUnit; 
        } 

        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $categories = ItemCategory::select(["id","name"])->get();

        return view("dashboard.supply", [
            'title' => $title, 
            'supply' => $supply,
            'medicalUnits' => $medicalUnits,
            'categories' => $categories,
            'id' => $id,   
        ]);
    } 

    public function supply_detail($id, $page = 1){
        $title ="routes.supply_detail";
        
        $supply = Item::findOr($id, function () {
            return false;
        });
        
        if(!$supply){
            return redirect('/dashboard/supplies/?msg='.__("messages.supplyNotExist")."_error");
        }

        if($supply->status == 0){
            return redirect('/dashboard/supplies/?msg='.__("messages.supplyDeleted")."_error");
        } 
        
        if(!$supply->medical_unit){
            $supply->medical_unit = new MedicalUnit; 
        } 

        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $categories = ItemCategory::select(["id","name"])->get();
        
        return view("dashboard.supply_detail", [
            'title' => $title, 
            'supply' => $supply,
            'medicalUnits' => $medicalUnits,
            'categories' => $categories,
            'id' => $id, 
            'page' => $page,   
        ]);
    } 

    public function expenses($page = 1){    

        return view("dashboard.expenses",[
            'page' => $page,   
        ]);
    } 

    public function expense($id = null){
        $title = $id ? "routes.update_expense" : "routes.create_expense";
        $expense = new Expense;   
        
        if($id){ 
            $expense = Expense::findOr($id, function () {
                return false;
            });
            
            if(!$expense){
                return redirect('/dashboard/expenses/?msg='.__("messages.expenseNotExist")."_error");
            }

            if($expense->status == 0){
                return redirect('/dashboard/expenses/?msg='.__("messages.expenseDeleted")."_error");
            } 
        }   
        
        return view("dashboard.expense", [
            'title' => $title, 
            'expense' => $expense, 
            'id' => $id,   
        ]);
    } 

    public function expenses_records($page = 1){    

        return view("dashboard.expenses_records",[
            'page' => $page,   
        ]);
    } 

    public function expenses_record($id = null){
        $title = $id ? "routes.update_expense_record" : "routes.create_expense_record";
        $expenseRecord = new ExpenseRecord;   
        
        if($id){ 
            $expenseRecord = ExpenseRecord::findOr($id, function () {
                return false;
            });
            
            if(!$expenseRecord){
                return redirect('/dashboard/expenses/?msg='.__("messages.expenseNotExist")."_error");
            }

            if($expenseRecord->status == 0){
                return redirect('/dashboard/expenses/?msg='.__("messages.expenseDeleted")."_error");
            } 
        }  

        if(!$expenseRecord->medical_unit){
            $expenseRecord->medical_unit = new MedicalUnit; 
        } 

        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $expenses = Expense::select(["id","name","barcode"])->get();
        
        $expenseRecord->items = $expenseRecord->items ? json_decode($expenseRecord->items) : [];
        $paymentMethods = [
            1  => __('payment_methods.credit_cards'),
            2  => __('payment_methods.debit_cards'),
            3  => __('payment_methods.cash_payments'),
            4  => __('payment_methods.bank_transfers'),
            5  => __('payment_methods.checks'),
        ];

        return view("dashboard.expenses_record", [
            'title' => $title, 
            'expenses' => $expenses,
            'expenseRecord' => $expenseRecord,
            'medicalUnits' => $medicalUnits,
            'paymentMethods' => $paymentMethods,
            'id' => $id,   
        ]);
    } 

    public function encounters($page = 1){  

        $encounterStatus = [
            __('messages.cancel_her'),
            __('messages.in_progress'),
            __('messages.payed'), 
        ];

        $encounterStatusColors = [
            'text-red-600',
            'text-gray-600',
            'text-blue-600',
            'text-emerald-600',
        ];

        return view("dashboard.encounters",[
            'page' => $page,   
            'encounterStatus' => $encounterStatus, 
            'encounterStatusColors' => $encounterStatusColors,   
        ]);
    } 

    public function encounter($id = null){
        $title = $id ? "routes.update_encounter" : "routes.create_encounter";
        $encounter = new Encounter;   
        
        if($id){ 
            $encounter = Encounter::findOr($id, function () {
                return false;
            });
            
            if(!$encounter){
                return redirect('/dashboard/encounters/?msg='.__("messages.encounterNotExist")."_error");
            }

            if($encounter->status == 0){
                return redirect('/dashboard/encounters/?msg='.__("messages.encounterDelete")."_error");
            } 
        } 

        if(!$encounter->patient){
            $encounter->patient = new Patient;
        }

        if(!$encounter->doctor){
            $encounter->doctor = new Doctor; 
        } 
        
        if($encounter->patient->user_id){
            $user = User::find($encounter->patient->user_id);
            $encounter->patient->fullName = $user->first_name." ".$user->last_name;
        }
 
        $doctors     = User::select(["doctors.id","users.id as user_id","first_name","last_name","medical_units"])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();
        $patients    = User::select([
                                        "patients.id",
                                        "users.id as user_id",
                                        "first_name",
                                        "last_name",
                                        "email",
                                        "phone",
                                        "patients.dob",
                                        "patients.blood_type",
                                        "users.gender",
                                        "users.language",
                                        "patients.doctor_id",
                                    ])->leftJoin('patients', 'users.id', '=', 'patients.user_id')->where(["role" => 3])->get();

        foreach ($doctors as $key => $doctor) {
            $doctors[$key]->medical_units = MedicalUnit::select(["id","name"])->whereIn("medical_units.id", array_values(json_decode($doctor->medical_units,true)))->get(); 
        }
        
        $paymentStatus = [
            __('payment_methods.credit_cards'),
            __('payment_methods.debit_cards'),
            __('payment_methods.cash_payments'),
            __('payment_methods.bank_transfers'),
            __('payment_methods.checks'),
            __('payment_methods.mobile_payments'),
            __('payment_methods.third_party_apps'),
            __('payment_methods.gift_cards'),
            __('payment_methods.corporate_credits'),
            __('payment_methods.account_payments'),
        ];

        $subjects = [];
        
        $id_patient = $encounter->patient->id;

        if(isset($_GET['patient'])){
            $id_patient = $_GET['patient'];
        }

        $prices = Setting::where(["module" => "appointments_prices"])->get();

        foreach ($prices as $price) {
            $subjects[] = $price->key;
        }
        
        return view("dashboard.encounter", [
            'title' => $title, 
            'encounter' => $encounter,
            'id' => $id,   
            'doctors' => $doctors,
            'patients' => $patients,
            'id_patient' => $id_patient,
            'paymentStatus' => $paymentStatus, 
            'subjects' => $subjects, 
            'prices' => $prices, 
        ]);
    } 

    public function encounter_detail($id){
        $title     =  "routes.encounter_detail"; 
        $encounter = Encounter::findOr($id, function () {
            return false;
        });
        
        if(!$encounter){
            return redirect('/dashboard/encounters/?msg='.__("messages.encounterNotExist")."_error");
        }

        if($encounter->status == 0){
            return redirect('/dashboard/encounters/?msg='.__("messages.encounterDelete")."_error");
        } 
         
        $encounter->doctor_user = User::findOr($encounter->doctor->user_id, function () {
            return false;
        }); 
        
        $paymentMethods = [
            1  => __('payment_methods.credit_cards'),
            2  => __('payment_methods.debit_cards'),
            3  => __('payment_methods.cash_payments'),
            4  => __('payment_methods.bank_transfers'),
            5  => __('payment_methods.checks'),
        ];

        $encounter->items = json_decode($encounter->items);
        $itemsReloadIDs = [];
        $items = [];

        foreach ($encounter->items as $key => $item) {
            if($encounter->items[$key]->type == "supply"){
                $itemsReloadIDs[] = $encounter->items[$key]->item_reload_id;
            }
        }

        $supplies = Item::select([
            'items.name',
            'items.barcode',
            'items.cat_id',
            'items.commission_amount', 
            'items.id as item_id',   
            'item_reloads.price',
            'item_reloads.remaining',   
            'item_reloads.id as item_reload_id',
            'items.type',  
            'item_reloads.expiration'
        ])
        ->leftJoin('item_reloads', 'items.id', '=', 'item_reloads.item_id')  
        ->where('medical_unit_id', $encounter->medical_unit_id)
        ->where('type', 'supply') 
        ->where('item_reloads.status', '!=', 0)    
        ->where('item_reloads.remaining', '!=', 0)
        ->where(function ($query) {
            $query->whereNull('item_reloads.expiration')  
                  ->orWhere('item_reloads.expiration', '>', Carbon::today()->toDateString());
        });
       
        if (!empty($itemsReloadIDs)) { 
            $supplies = $supplies->whereNotIn('item_reloads.id', $itemsReloadIDs);

            $currentSupplies = Item::select([
                'items.barcode',
                'items.cat_id',
                'items.commission_amount', 
                'items.cost',
                'items.description',    
                'items.id',   
                'item_reloads.price',
                'item_reloads.remaining',   
                'item_reloads.id as item_reload_id',
                'items.type', 
                'items.name',  
            ])
            ->join('item_reloads', 'items.id', '=', 'item_reloads.item_id')  
            ->where('medical_unit_id', $encounter->medical_unit_id)
            ->where('type', 'supply')
            ->whereIn('item_reloads.id', $itemsReloadIDs)
            ->get()
            ->map(function ($item) { 
                $item->name = $item->name . ' $ ' .$item->price;
    
                return [
                    "name" => $item->name,
                    "barcode" => $item->barcode,
                    "cat_id" => $item->cat_id,
                    "commission_amount" => $item->commission_amount,
                    "id" => $item->id,
                    "price" => $item->price,
                    "type" => $item->type,
                    "name" => $item->name, 
                    "remaining" => $item->remaining,
                    "item_reload_id" => $item->item_reload_id,
                ];
            });
            
            foreach ($currentSupplies as $supply) {   
                $updatedItems = [];  
                
                foreach ($encounter->items as $item) {
                    if($item->type == "supply"){
                        if ($item->item_reload_id === $supply['item_reload_id']) { 
                            $supply['remaining'] += $item->qty;     
                            $item->remaining = $supply['remaining'];    
                        }
                    }

                    $updatedItems[] = $item; 
                }
            
                $encounter->items = collect($updatedItems);  
                $items[] = $supply;
            }
        }
        
        $supplies = $supplies->get()
        ->map(function ($item) { 
            $item->name = $item->name . ' $ ' .$item->price;

            return [
                "name" => $item->name,
                "barcode" => $item->barcode,
                "cat_id" => $item->cat_id,
                "commission_amount" => $item->commission_amount,
                "id" => $item->id,
                "price" => $item->price,
                "type" => $item->type,
                "name" => $item->name, 
                "remaining" => $item->remaining,
                "item_reload_id" => $item->item_reload_id,
                "expiration" => $item->expiration,
            ];
        }); 
        
        $services = Item::select([
            'items.barcode',
            'items.cat_id',
            'items.commission_amount', 
            'items.cost', 
            'items.id',   
            'items.price',   
            'items.type', 
            'items.name', 
            'area_categories.name as area_name' 
        ])
        ->leftJoin('area_categories', 'area_categories.id', '=', 'items.area_id')  
        ->where('medical_unit_id',$encounter->medical_unit_id) 
        ->where("type","service")
        ->get()
        ->map(function ($item) { 
            if ($item->area_name) { 
                $item->name = $item->name . ' ' . __('areas.' . $item->area_name);
            }

            return [
                "name" => $item->name,
                "barcode" => $item->barcode,
                "cat_id" => $item->cat_id,
                "commission_amount" => $item->commission_amount,
                "id" => $item->id,
                "price" => $item->price,
                "type" => $item->type,
                "name" => $item->name,
                "area_name" => $item->area_name,
            ];
        });

    
        foreach ($supplies as $key => $supply) {
            $items[] = $supply;
        }

        foreach ($services as $key => $service) {
            $items[] = $service;
        }
        
        usort($items, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        $lastAppointmentDate = Appointment::select(['date'])->where('date', '<=', now())  // Fecha antes de ahora
                            ->where('status', '!=', '0')  
                            ->where("patient_id", $encounter->patient->id)
                            ->orderBy('date', 'desc')
                            ->limit(1); 
                            
        $lastEncounterDate = Encounter::select(['date'])->where('date', '<=', now())  
                            ->where('status', '2')  
                            ->where("patient_id", $encounter->patient->id)
                            ->orderBy('date', 'desc')
                            ->limit(1); 
        
        $totalCombinedSum = Encounter::where('status', '2')
                                    ->where("patient_id", $encounter->patient->id)
                                    ->selectRaw('SUM(total + subtotal) as total_combined_sum')
                                    ->value('total_combined_sum');
        
        $encounter->patient->medical_histories = MedicalHistory::where(["patient_id" => $encounter->patient->id])->get()[0];
        $encounter->patient->user = User::findOr($encounter->patient->user_id, function () {
            return false;
        });

        $encounter->patient->doctor = Doctor::findOr($encounter->patient->doctor_id, function () {
            return false;
        });
        $encounter->patient->doctor->user = User::findOr($encounter->patient->doctor->user_id, function () {
            return false;
        });

        $encounter->patient->encounters = Encounter::where("patient_id", $encounter->patient->id)->count();
        $encounter->patient->appointments = Appointment::where("patient_id", $encounter->patient->id)->count();
        
        return view("dashboard.encounter_detail", [
            'title' => $title, 
            'encounter' => $encounter,
            'lastAppointmentDate' => $lastAppointmentDate,
            'lastEncounterDate' => $lastEncounterDate,
            'totalCombinedSum' => $totalCombinedSum, 
            'id' => $id,    
            'paymentMethods' => $paymentMethods, 
            'items' => $items,   
            'patient' => $encounter->patient,  
        ]);
    }

    public function appointments($page = 1){   
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

        if (!$appointment) {
            $appointment = false;
        }

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

        return view("dashboard.appointments",[
            'page' => $page,   
            'appointmentStatus' => $appointmentStatus, 
            'appointmentStatusColors' => $appointmentStatusColors,   
            'appointment' => $appointment, 
            'appointment_id' => $appointment_id,   
        ]);
    } 

    public function appointment($id = null){
        $title = $id ? "routes.update_appointment" : "routes.create_appointment";
        $appointment = new Appointment;   
        
        if($id){ 
            $appointment = Appointment::findOr($id, function () {
                return false;
            });
            
            if(!$appointment){
                return redirect('/dashboard/appointments/?msg='.__("messages.appointmentNotExist")."_error");
            }

            if($appointment->status == 0){
                return redirect('/dashboard/appointments/?msg='.__("messages.appointmentDeleted")."_error");
            } 
        } 

        if(!$appointment->patient){
            $appointment->patient = new Patient;
        }

        if(!$appointment->doctor){
            $appointment->doctor = new Doctor; 
        } 
        
        if($appointment->patient->user_id){
            $user = User::find($appointment->patient->user_id);
            $appointment->patient->fullName = $user->first_name." ".$user->last_name;
        }
 
        $doctors     = User::select(["doctors.id","users.id as user_id","first_name","last_name",'medical_units','offer_discount'])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();
        $patients    = User::select([
            "patients.id",
            "users.id as user_id",
            "first_name",
            "last_name",
            "email",
            "phone",
            "patients.dob",
            "patients.blood_type",
            "users.gender",
            "users.language",
            "patients.doctor_id",
        ])->leftJoin('patients', 'users.id', '=', 'patients.user_id')->where(["role" => 3])->get();
        
        foreach ($doctors as $key => $doctor) {
            $doctors[$key]->medical_units = MedicalUnit::select(["id","name"])->whereIn("medical_units.id", array_values(json_decode($doctor->medical_units,true)))->get(); 
        }
         
        $subjects = [];

        $paymentStatus = [
            __('payment_methods.credit_cards'),
            __('payment_methods.debit_cards'),
            __('payment_methods.cash_payments'),
            __('payment_methods.bank_transfers'), 
        ];

        $id_patient = "";

        if(isset($_GET['patient'])){
            $id_patient = $_GET['patient'];
        }

        if($appointment->patient_id){
            $id_patient = $appointment->patient_id;
        }

        $prices = Setting::where(["module" => "appointments_prices"])->get();

        foreach ($prices as $price) {
            $subjects[] = $price->key;
        }

        $medicalUnits = MedicalUnit::select(["id","name" ])->get();

        return view("dashboard.appointment", [
            'title' => $title, 
            'appointment' => $appointment,
            'id' => $id,   
            'doctors' => $doctors,
            'patients' => $patients,
            'paymentStatus' => $paymentStatus, 
            'id_patient' => $id_patient, 
            'subjects' => $subjects,
            'prices' => $prices, 
            'medicalUnits' => $medicalUnits, 
        ]);
    } 

    public function medicals($page = 1){  
        return view("dashboard.medicals",[
            'page' => $page,   
        ]);
    } 

    public function patients($page = 1){  
        $doctors  = User::select(["doctors.id","users.id as user_id","first_name","last_name","medical_units"])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();
        $medicalUnits = MedicalUnit::select([
            "id",
            "name",
            "address",
            "city",
            "zipcode",
            "country",
            DB::raw("CONCAT(address,', ',city,', ',zipcode,', ',country) AS fulladdress"),
            ])->get();
        $areas = AreaCategory::get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => __("areas.".$item->name),  
                ];
            });
     
        return view("dashboard.patients",[
            'page' => $page, 
            'doctors' => $doctors,   
            'medicalUnits' => $medicalUnits,   
            'areas' => $areas,    
        ]);
    } 

    public function patient_detail($id){  
        $patient = Patient::findOr($id, function () {
            return false;
        });
        
        if(!$patient){
            return redirect('/dashboard/patients/?msg='.__("messages.patientNotExist")."_error");
        } 

        $patient->user = User::findOr($patient->user_id, function () {
            return false;
        });
        
        if(!$patient->user){
            return redirect('/dashboard/users/?msg='.__("messages.userNotExist")."_error");
        } 

        $patient->user->genderText = __("messages.".$patient->user->gender);
        $patient->doctor = Doctor::findOr($patient->doctor_id, function () {
            return false;
        });
        
        if(!$patient->doctor){
            return redirect('/dashboard/medicals/?msg='.__("messages.doctorNotExist")."_error");
        } 

        $patient->doctor->user = User::findOr($patient->doctor->user_id, function () {
            return false;
        });
        
        if(!$patient->doctor->user){
            return redirect('/dashboard/users/?msg='.__("messages.userNotExist")."_error");
        }
        
        $patient->medical_histories = MedicalHistory::where(["patient_id" => $patient->id])->get()[0];
        $patient->medical_histories->marital_statusText =  $patient->medical_histories->marital_status ? __('messages.'.$patient->medical_histories->marital_status) : "";
        $patient->encounters = Encounter::where("patient_id", $patient->id)->count();
        $patient->appointments = Appointment::where("patient_id", $patient->id)->count();
        $patient->age = \Carbon\Carbon::parse($patient->dob)->age;
        
        $lastAppointmentDate = Appointment::select(['date'])->where('date', '<=', now())  // Fecha antes de ahora
                            ->where('status', '!=', '0')  
                            ->where("patient_id", $patient->id)
                            ->orderBy('date', 'desc')
                            ->limit(1); 
                            
        $lastEncounterDate = Encounter::select(['date'])->where('date', '<=', now())  
                            ->where('status', '2')  
                            ->where("patient_id", $patient->id)
                            ->orderBy('date', 'desc')
                            ->limit(1); 
        
        $totalCombinedSum = Encounter::where('status', '2')
                                    ->where("patient_id", $patient->id)
                                    ->selectRaw('SUM(total + subtotal) as total_combined_sum')
                                    ->value('total_combined_sum');
        
        $supplyItems = Encounter::whereNotNull('items')->where("patient_id", $patient->id)->get()
                                ->flatMap(function ($encounter) {
                                    $items = json_decode($encounter->items, true);
                                    return collect($items)
                                        ->where('type', 'supply')
                                        ->map(function ($item) {
                                            return [
                                                'id' => $item['id'],
                                                'name' => $item['name'],
                                                'qty' => (int) $item['qty'],
                                                'price' => (float) $item['price'],
                                            ];
                                        });
                                })
                                ->groupBy('id')
                                ->map(function ($items, $id) {
                                    // Calcula la cantidad total y el total por precio
                                    return [
                                        'name' => $items->first()['name'],
                                        'total_qty' => $items->sum('qty'),
                                        'total_price' => $items->sum(fn($item) => $item['qty'] * $item['price']),
                                    ];
                                });

        $serviceItems = Encounter::whereNotNull('items')->where("patient_id", $patient->id)->get()
                                ->flatMap(function ($encounter) {
                                    $items = json_decode($encounter->items, true);
                                    return collect($items)
                                        ->where('type', 'service')
                                        ->map(function ($item) {
                                            return [
                                                'id' => $item['id'],
                                                'name' => $item['name'],
                                                'qty' => (int) $item['qty'],
                                                'price' => (float) $item['price'],
                                            ];
                                        });
                                })
                                ->groupBy('id')
                                ->map(function ($items, $id) {
                                    // Calcula la cantidad total y el total por precio
                                    return [
                                        'name' => $items->first()['name'],
                                        'total_qty' => $items->sum('qty'),
                                        'total_price' => $items->sum(fn($item) => $item['qty'] * $item['price']),
                                    ];
                                });

        return view("dashboard.patient_detail",[
            'patient' => $patient,    
            'id' => $id,  
            'lastAppointmentDate' => $lastAppointmentDate,    
            'lastEncounterDate' => $lastEncounterDate,       
            'totalCombinedSum' => $totalCombinedSum, 
            'supplyItems' => $supplyItems,    
            'serviceItems' => $serviceItems,    
        ]);
    } 

    public function patient_record($id){ 
        
        $patient = Patient::findOr($id, function () {
            return false;
        });
        
        if(!$patient){
            return redirect('/dashboard/patients/?msg='.__("messages.patientNotExist")."_error");
        } 

        $patient->user = User::findOr($patient->user_id, function () {
            return false;
        });
        
        if(!$patient->user){
            return redirect('/dashboard/users/?msg='.__("messages.userNotExist")."_error");
        } 

        $patient->doctor = Doctor::findOr($patient->doctor_id, function () {
            return false;
        });
        
        if(!$patient->doctor){
            return redirect('/dashboard/medicals/?msg='.__("messages.doctorNotExist")."_error");
        } 

        $patient->doctor->user = User::findOr($patient->doctor->user_id, function () {
            return false;
        });
        
        if(!$patient->doctor->user){
            return redirect('/dashboard/users/?msg='.__("messages.userNotExist")."_error");
        }
        
        $patient->medical_histories = MedicalHistory::where(["patient_id" => $patient->id])->get()[0];
        $patient->medical_histories->marital_statusText =  $patient->medical_histories->marital_status ? __('messages.'.$patient->medical_histories->marital_status) : "";
        $patient->age = \Carbon\Carbon::parse($patient->dob)->age;

        return view("dashboard.patient_record",[
            'patient' => $patient,    
            'id' => $id,    
        ]);
    } 

    public function certificates($page = 1){  
        $certificateStatus = [
            __('messages.canceled_his'),
            __('messages.pending'),
            __('messages.signeds_his'),
            __('messages.expired_his'), 
        ];

        $certificateStatusColors = [
            'text-red-600',
            'text-gray-600',
            'text-blue-600',
            'text-emerald-600',
        ];

        return view("dashboard.certificates",[
            'page' => $page,   
            'certificateStatus' => $certificateStatus, 
            'certificateStatusColors' => $certificateStatusColors,  
        ]);
    } 

    public function certificate($id = null){  
        $certificate = new Certificate;
        $request_id = "";
        $request = new CertificateRequest;

        if($id){
            $certificate = Certificate::findOr($id, function () {
                return false;
            });

            if(!$certificate){
                return redirect('/dashboard/certificates/?msg='.__("messages.certificateNotExist")."_error");
            }
        }
   
        if(!$certificate->doctor){
            $certificate->doctor = new Doctor;
        }

        if(!$certificate->patient){
            $certificate->patient = new Patient;
        } 

        if(isset($_GET['patient_id'])){
            $certificate->patient_id = $_GET['patient_id'];
            $certificate->patient = Patient::find($_GET['patient_id']);
            $certificate->doctor = Doctor::find($certificate->patient->doctor_id);
        }

        if(Auth::user()->role == 2 ){
            $certificate->doctor = Auth::user()->doctor;
        }
         
        $doctors  = User::select(["doctors.id","users.id as user_id","first_name","last_name"])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();

        if(isset($_GET['requests_id'])){
            $request_id = $_GET['requests_id'];
            $request = CertificateRequest::find($request_id);

            $certificate->type = $request->type;
            $certificate->notes = $request->notes;
            $certificate->patient_id = $request->patient_id;
            $certificate->patient = Patient::find($request->patient_id);
            $certificate->doctor = Doctor::find($request->doctor_id);
        }

        return view("dashboard.certificate",[ 
            'certificate' => $certificate,    
            'id' => $id,   
            'doctors' => $doctors,  
            'request_id' => $request_id,
            'request' => $request,
        ]);
    } 

    public function users($page = 1){ 
        $specialties = Specialty::select(["id","name"])->get();

        return view("dashboard.users",[
            'page' => $page,  
            'specialties' => $specialties,  
        ]);
    } 
    
    public function user($id = null){
        $title = $id ? "routes.update_user" : "routes.create_user";

        if(isset($_GET['role'])){
            if($_GET['role'] == 2){
                $title = $id ? "routes.update_medical" : "routes.create_medical";
            }else{
                $title = $id ? "routes.update_patient" : "routes.create_patient";
            }
        }

        $user = new User;   
        
        if($id){ 
            $user = User::findOr($id, function () {
                return false;
            });
            
            if(!$user){
                return redirect('/dashboard/users/?msg='.__("messages.userNotExist")."_error");
            }

            if($user->status == 0){
                return redirect('/dashboard/users/?msg='.__("messages.userDeleted")."_error");
            } 
        } 

        if(!$user->patient){
            $user->patient = new Patient;
        }

        if(!$user->doctor){
            $user->doctor = new Doctor;
            $user->doctor->specialty_ids = [];
        }else{
            $user->doctor->specialty_ids = json_decode($user->doctor->specialty_ids);
        }

        $role = $user->role ? $user->role : 0;

        if(isset($_GET['role'])){
            $role = $_GET['role'];
        }

        if(Auth::user()->role == 2 && $role != 3){
            return redirect('/dashboard');
        }

        $specialties  = Specialty::select(["id","name"])->get();
        $doctors      = User::select(["doctors.id","users.id as user_id","first_name","last_name"])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();
        $medicalUnits = MedicalUnit::select(["id","name"])->where("status",1)->get();

        return view("dashboard.user", [
            'title' => $title, 
            'user' => $user,
            'id' => $id,  
            'specialties' => $specialties,
            'doctors' => $doctors,
            'medicalUnits' => $medicalUnits,
            'role' => $role,
        ]);
    } 


    public function templates($page = 1){ 
        return view("dashboard.templates", []);
    } 

    public function template($id = null){
        $title = $id ? "routes.update_supply" : "routes.create_supply";
        $template = new Template;   

        return view("dashboard.template", [
            "title" => $title,
            "id" => $id,
            "template" => $template,
        ]);
    } 

    public function requests($page = 1){ 
        $request = false;
        $request_id = '';

        if(isset($_GET['request'])){
            $request_id = $_GET['request'];
            $request = CertificateRequest::select([
                DB::raw("CONCAT(patient_user.first_name,' ',patient_user.last_name) AS patient"), 
                DB::raw("CONCAT(doctor_user.first_name,' ',doctor_user.last_name) AS doctor"), 
                "patient_user.image",
                "certificate_requests.id",
                "certificate_requests.type",  
                "certificate_requests.notes", 
                "certificate_requests.status", 
                "certificate_requests.rejection_reason",
                "certificate_requests.certificate_id",
            ])
            ->leftJoin('patients', 'certificate_requests.patient_id', '=', 'patients.id')
            ->leftJoin('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
            ->leftJoin('doctors', 'certificate_requests.doctor_id', '=', 'doctors.id')
            ->leftJoin('users as doctor_user', 'doctors.user_id', '=', 'doctor_user.id')
            ->where('certificate_requests.id', $_GET['request'])
            ->first();
        }

        if (!$request) {
            $request = false;
        }
        return view("dashboard.requests", [
            'page' => $page,  
            'request' => $request,  
            'request_id' => $request_id,  
        ]);
    } 

    public function profile(){
        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        $specialties  = Specialty::select(["id","name"])->get();

        return view("dashboard.profile", [ 
            "medicalUnits" => $medicalUnits,
            "specialties" => $specialties, 
        ]);
    }

    public function settings(){
        $settings = Setting::get();
        $subjects = [];
        $specialties = [];
        
        $languages = array_map(function ($path) {
            return basename($path);
        }, File::directories(resource_path('lang')));

        foreach ($languages as $lang) {
            $subjects[$lang] = Lang::get('subjects', [], $lang);
            $specialties[$lang] = Lang::get('specialties', [], $lang);
        }
        //print_r(Setting::select(['value'])->where("module","appointments_prices")->get());
        $colors = Setting::select(['value'])->where("key","colors")->first();
        $colors = $colors ? json_decode($colors->value) : NULL; 
     
        return view("dashboard.settings", [ 
            "settings" => $settings,
            "colors" => $colors, 
            "subjects" => $subjects,
            "specialties" => $specialties,
            "languages" => $languages,
        ]);
    }

    public function report(){ 
        $medicalUnits = MedicalUnit::select(["id","name"])->get();

        return view("dashboard.report", [ 
            "medicalUnits" => $medicalUnits,
        ]);
    }
}