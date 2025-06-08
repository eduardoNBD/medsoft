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
use App\Rules\ValidExpiration;
use Carbon\Carbon;

class SuppliesController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'medical_unit' => 'required', 
            'barcode' => 'required', 
            'category' => 'required', 
            'commission' => 'required|numeric|max:90', 
            'expiration' => [new ValidExpiration(__('rules.expiration_date'))],
        ],
        [
            'name.required' => __('rules.name_required'),
            'medical_unit.required' => __('rules.medical_unit_required'),  
            'barcode.required' => __('rules.barcode_required'),
            'category.required' => __('rules.category_required'),
            'commission.required' => __('rules.commission_required'), 
            'commission.numeric' => __('rules.commission_numeric'),
            'commission.max' => __('rules.commission_max'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $supply = new Item;
         
        $supply->name = $request->input("name");
        $supply->medical_unit_id = $request->input("medical_unit"); 
        $supply->barcode = $request->input("barcode");
        $supply->cat_id = $request->input("category");
        $supply->commission_amount = $request->input("commission"); 
        $supply->description = $request->input("description");
        $supply->type = "supply"; 
        $supply->created_by = Auth::user()->id; 
        
        $supply->save();
        
        $main  = $request->file("imgSupply");
        $image = "";
        
        if($main){
            $image = $main->store("items/".$supply->id); 
            $supply->image = $image; 
              
            $supply->save();
        } 
        
        return response()->json(["status" => 1, "message" => __("messages.supplyCreated")]);
    } 

    public function update(Request $request, $id){  
        $supply = Item::findOr($id, function () {
            return false;
        });

        if(!$supply){
            return response()->json(["status" => 0, "message" => __("messages.supplyNotExist")]);
        }

        if($supply->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.supplyDelete")]);
        }

        $validator = Validator::make(request()->all(), [
            'name' => 'required',  
            'barcode' => 'required', 
            'category' => 'required', 
            'commission' => 'required|numeric|max:90', 
            'expiration' => [new ValidExpiration(__('rules.expiration_date'))],
        ],[
            'name.required' => __('rules.name_required'),  
            'barcode.required' => __('rules.barcode_required'),
            'category.required' => __('rules.category_required'),
            'commission.required' => __('rules.commission_required'), 
            'commission.numeric' => __('rules.commission_numeric'),
            'commission.max' => __('rules.commission_max'), 
            'expiration.regex' => __('rules.expiration_regex'),
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }  
    
        $medicalUnit = MedicalUnit::findOr($supply->medical_unit_id, function () {
            return false;
        });

        if(!$medicalUnit){
            return response()->json(["status" => 0, "message" => __("messages.medicalUnitNotExist")]);
        } 
        
        $supply->name = $request->input("name");  
        $supply->barcode = $request->input("barcode");
        $supply->cat_id = $request->input("category");
        $supply->commission_amount = $request->input("commission"); 
        $supply->description = $request->input("description");  
        $supply->save();

        $main  = $request->file("imgSupply");
        $image = $supply->image ? $supply->image : "";

        if($main){
            $image =  $main->store("gallery/".$supply->id); 

            if($supply->image != "0" && $supply->image != "" && Storage::exists($supply->image)) {
                Storage::delete($supply->image); 
            } 
        }

        if($request->input("maindeleted")){
            if($supply->image != "0" && $supply->image != "" && Storage::exists($supply->image)) {
                Storage::delete($supply->image); 
                $image = "";
            } 
        }

        $supply->image = $image; 
        
        $supply->save(); 

        return response()->json(["status" => 1, "message" => __("messages.supplyUpdate")]);
    }

    public function list(Request $request){ 
        $supplies = Item::leftJoin('item_categories', 'item_categories.id', '=', 'items.cat_id') 
                          ->leftJoin('medical_units', 'medical_units.id', '=', 'items.medical_unit_id')  
                          ->leftJoin( DB::raw("(SELECT item_id, COALESCE(SUM(remaining), 0) as total_remaining 
                                      FROM item_reloads 
                                      WHERE expiration IS NULL OR expiration > '" . Carbon::now()->toDateString() . "'
                                      GROUP BY item_id) as reloads"),'reloads.item_id', '=', 'items.id') 
                          ->leftJoin(DB::raw("(SELECT item_id, MIN(expiration) as nearest_expiration 
                                                  FROM item_reloads 
                                                  WHERE expiration IS NOT NULL 
                                                  GROUP BY item_id) as expirations"),
                                        'expirations.item_id', '=', 'items.id')
                          ->where("items.type", "supply")
                          ->whereIn("items.status", $request->input("status"));

        if($request->input("s")){
            $search = $request->input("s") . '%';
        
            $supplies->where(function ($query) use ($search) {
                $query->where('items.name', 'like', $search)
                        ->orWhere('items.barcode', 'like', $search) 
                        ->orWhere("medical_units.name", 'like', $search);
            });
        }
        
        if($request->input("category") != ""){
            $supplies->where("items.cat_id", $request->input("category"));
        }

        if(Auth::user()->role == 2){
            $doctor = Doctor::where('user_id',Auth::user()->id)->first();
            
            $medicalUnits = json_decode($doctor->medical_units, true); 
            
            if (is_array($medicalUnits) && !empty($medicalUnits)) { 
                $supplies->whereIn('items.medical_unit_id', $medicalUnits);
            }
        } 

        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalSupplies = $supplies->count();
        $totalPages = ceil($totalSupplies / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "items.id",
            "items.name",
            "items.image",  
            "medical_units.name as medical_unit", 
            "items.description", 
            "items.barcode",
            "items.price",
            "items.cost",
            "items.status",
            "item_categories.name as category",
            DB::raw("COALESCE(reloads.total_remaining, 0) as total_remaining"),
            "expirations.nearest_expiration as expiration",
        ];

        $supplies = $supplies->paginate($perPage, $fields, 'items', $page);
         
        $supplies->getCollection()->transform(function ($item) { 
            $item->category = __("item_categories." . $item->category);  
            return $item;
        });
        
        return response()->json(["status" => 1, 'items' => $supplies ]);
    } 

    public function delete(Request $request, $id){ 
        $supply = Item::findOr($id, function () {
            return false;
        });

        if(!$supply){
            return response()->json(["status" => 0, "message" => __("messages.supplyNotExist")]);
        }
        
        $supply->status = 0;
        $supply->save(); 

        return response()->json(["status" => 1, "message" => __("messages.supplyDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $supply = Item::findOr($id, function () {
            return false;
        });

        if(!$supply){
            return response()->json(["status" => 0, "message" => __("messages.supplyNotExist")]);
        }
        
        $supply->status = 1;
        $supply->save(); 

        return response()->json(["status" => 1, "message" => __("messages.supplyRestored")]);
    } 
}



