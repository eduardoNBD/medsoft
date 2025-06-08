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
    MedicalUnit,
    Item,
    Doctor
}; 

class ServicesController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'name' => 'required', 
            'medical_unit' => 'required',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', 
            'barcode' => 'required', 
            'category' => 'required', 
            'commission' => 'required|numeric|max:90', 
        ],
        [
            'name.required' => __('rules.name_required'),
            'medical_unit.required' => __('rules.medical_unit_required'), 
            'price.required' => __('rules.price_required'),
            'price.numeric' => __('rules.price_numeric'),
            'price.regex' => __('rules.price_regex'), 
            'barcode.required' => __('rules.barcode_required'),
            'category.required' => __('rules.category_required'),
            'commission.required' => __('rules.commission_required'), 
            'commission.numeric' => __('rules.commission_numeric'),
            'commission.max' => __('rules.commission_max'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $service = new Item;
         
        $service->name = $request->input("name");
        $service->medical_unit_id = $request->input("medical_unit"); 
        $service->price = $request->input("price");
        $service->barcode = $request->input("barcode");
        $service->cat_id = $request->input("category");
        $service->commission_amount = $request->input("commission"); 
        $service->description = $request->input("description");
        $service->type = "service"; 
        $service->area_id =  $request->input("area");
        $service->created_by = Auth::user()->id;

        $service->save();
        
        $main  = $request->file("imgService");
        $image = "";
        
        if($main){
            $image = $main->store("items/".$service->id); 
            $service->image = $image; 
              
            $service->save();
        } 
        
        return response()->json(["status" => 1, "message" => __("messages.serviceCreated")]);
    } 

    public function update(Request $request, $id){  
        $service = Item::findOr($id, function () {
            return false;
        });

        if(!$service){
            return response()->json(["status" => 0, "message" => __("messages.serviceNotExist")]);
        }

        if($service->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.serviceDelete")]);
        }

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', 
            'barcode' => 'required', 
            'category' => 'required', 
            'commission' => 'required|numeric|max:90', 
        ],
        [
            'name.required' => __('rules.name_required'),
            'price.required' => __('rules.price_required'),
            'price.numeric' => __('rules.price_numeric'),
            'price.regex' => __('rules.price_regex'), 
            'barcode.required' => __('rules.barcode_required'),
            'category.required' => __('rules.category_required'),
            'commission.required' => __('rules.commission_required'), 
            'commission.numeric' => __('rules.commission_numeric'),
            'commission.max' => __('rules.commission_max'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }  
 
        $medicalUnit = MedicalUnit::findOr($service->medical_unit_id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        } 
        
        $service->name = $request->input("name"); 
        $service->price = $request->input("price");
        $service->barcode = $request->input("barcode");
        $service->cat_id = $request->input("category");
        $service->commission_amount = $request->input("commission"); 
        $service->description = $request->input("description");
        $service->area_id =  $request->input("area");

        $service->save();

        $main  = $request->file("imgService");
        $image = $service->image ? $service->image : "";

        if($main){
            $image =  $main->store("gallery/".$service->id); 

            if($service->image != "0" && $service->image != "" && Storage::exists($service->image)) {
                Storage::delete($service->image); 
            } 
        }

        if($request->input("maindeleted")){
            if($service->image != "0" && $service->image != "" && Storage::exists($service->image)) {
                Storage::delete($service->image); 
                $image = "";
            } 
        }

        $service->image = $image; 
        
        $service->save(); 

        return response()->json(["status" => 1, "message" => __("messages.serviceUpdate")]);
    }

    public function list(Request $request){ 
        $services = Item::leftJoin('item_categories', 'item_categories.id', '=', 'items.cat_id') 
                            ->leftJoin('medical_units', 'medical_units.id', '=', 'items.medical_unit_id')
                            ->leftJoin('area_categories','area_categories.id','items.area_id')
                            ->where("items.type", "service")
                            ->whereIn("items.status", $request->input("status"));

        if($request->input("s")){
            $search = $request->input("s") . '%';
        
            $services->where(function ($query) use ($search) {
                $query->where('items.name', 'like', $search)
                        ->orWhere('items.barcode', 'like', $search)
                        ->orWhere("medical_units.name", 'like', $search);
            });
        }
        
        if($request->input("category") != ""){
            $services->where("items.cat_id", $request->input("category"));
        }

        if(Auth::user()->role == 2){
            $doctor = Doctor::where('user_id',Auth::user()->id)->first();
            
            $medicalUnits = json_decode($doctor->medical_units, true); 
            
            if (is_array($medicalUnits) && !empty($medicalUnits)) { 
                $services->whereIn('items.medical_unit_id', $medicalUnits);
            }
        } 

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalServices = $services->count();
        $totalPages = ceil($totalServices / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "items.id",
            "items.name", 
            "medical_units.name as medical_unit", 
            "items.description",
            "items.barcode",
            "items.price",
            "items.cost",
            "items.status",
            "area_categories.name as area_name",
            "item_categories.name as category"
        ];

        $services = $services->paginate($perPage, $fields, 'items', $page);
         
        $services->getCollection()->transform(function ($item) { 
            $item->category = __("item_categories." . $item->category);  
            $item->area_name = __("areas." . $item->area_name);  
            return $item;
        });
        
        return response()->json(["status" => 1, 'items' => $services ]);
    } 

    public function delete(Request $request, $id){ 
        $service = Item::findOr($id, function () {
            return false;
        });

        if(!$service){
            return response()->json(["status" => 0, "message" => __("messages.serviceNotExist")]);
        }
        
        $service->status = 0;
        $service->save(); 

        return response()->json(["status" => 1, "message" => __("messages.serviceDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $service = Item::findOr($id, function () {
            return false;
        });

        if(!$service){
            return response()->json(["status" => 0, "message" => __("messages.serviceNotExist")]);
        }
        
        $service->status = 1;
        $service->save(); 

        return response()->json(["status" => 1, "message" => __("messages.serviceRestored")]);
    } 
}



