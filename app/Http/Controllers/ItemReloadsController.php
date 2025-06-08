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
    ItemReload,
    Doctor
}; 
use App\Rules\ValidExpiration;
use Carbon\Carbon;

class ItemReloadsController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'cost' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',  
            'qty' => 'required|numeric', 
            'expiration' => [new ValidExpiration(__('rules.expiration_date'))],
        ],
        [
            'price.required' => __('rules.price_required'),
            'price.numeric' => __('rules.price_numeric'),
            'price.regex' => __('rules.price_regex'),
            'cost.required' => __('rules.cost_required'),
            'cost.numeric' => __('rules.cost_numeric'),
            'qty.required' => __('rules.qty_required'),
            'qty.numeric' => __('rules.qty_numeric'),
            'cost.regex' => __('rules.cost_regex'), 
            'expiration.regex' => __('rules.expiration_regex'),
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $itemReload = new ItemReload;
         
        $itemReload->expiration = $request->input("expiration"); 
        $itemReload->quantity = $request->input("qty"); 
        $itemReload->remaining = $request->input("qty"); 
        $itemReload->cost = $request->input("cost");
        $itemReload->price = $request->input("price");  
        $itemReload->item_id = $request->input("item_id");  
        $itemReload->created_by = Auth::user()->id;

        if($request->input("expiration")){
            $itemReload->expiration = $request->input("expiration"); 
        }
        
        $itemReload->save();
         
        return response()->json(["status" => 1, "message" => __("messages.supplyReloadCreated")]);
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
            'cost' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', 
            'barcode' => 'required', 
            'category' => 'required', 
            'commission' => 'required|numeric|max:90', 
            'expiration' => [new ValidExpiration(__('rules.expiration_date'))],
        ],[
            'name.required' => __('rules.name_required'), 
            'price.required' => __('rules.price_required'),
            'price.numeric' => __('rules.price_numeric'),
            'price.regex' => __('rules.price_regex'),
            'cost.required' => __('rules.cost_required'),
            'cost.numeric' => __('rules.cost_numeric'),
            'cost.regex' => __('rules.cost_regex'),
            'barcode.required' => __('rules.barcode_required'),
            'category.required' => __('rules.category_required'), 
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
        $supply->cost = $request->input("cost");
        $supply->price = $request->input("price");
        $supply->barcode = $request->input("barcode");
        $supply->cat_id = $request->input("category"); 
        $supply->description = $request->input("description"); 

        if($request->input("expiration")){
            $supply->expiration = $request->input("expiration"); 
        }

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

    public function list(Request $request,$item_id){  
        $itemRealoads = ItemReload::leftJoin('items', 'item_reloads.item_id', '=', 'items.id')
                                    ->whereIn("item_reloads.status", $request->input("status"))
                                    ->where("item_reloads.item_id", $item_id);

        if($request->input("s")){
            $search = $request->input("s") . '%';
        
            $itemRealoads->where(function ($query) use ($search) {
                $query->where('items.name', 'like', $search)
                        ->orWhere('items.barcode', 'like', $search) 
                        ->orWhere("medical_units.name", 'like', $search);
            });
        }

        if($request->input("start_date") && $request->input("end_date")){
            $itemRealoads->where(function ($query) use ($request) {
                $start = Carbon::parse($request->input("start_date"));
                $end = Carbon::parse($request->input("end_date")." 23:59:59");
                $query->whereBetween('item_reloads.created_at', [$start, $end]);
            }); 
        } 
 
        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalitemRealoads = $itemRealoads->count();
        $totalPages = ceil($totalitemRealoads / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "item_reloads.id", 
            "item_reloads.quantity",
            "item_reloads.remaining", 
            "item_reloads.expiration", 
            "item_reloads.price",
            "item_reloads.cost", 
            "item_reloads.status", 
            "item_reloads.created_at", 
        ];

        $itemRealoads = $itemRealoads->paginate($perPage, $fields, 'item_reloads', $page); 

        $itemRealoads->getCollection()->transform(function ($item) {
            $item->is_expired = $item->expiration && $item->expiration < Carbon::today()->toDateString();
            return $item;
        });

        return response()->json(["status" => 1, 'items' => $itemRealoads ]);
    } 

    public function delete(Request $request, $id){ 
        $itemReload = ItemReload::findOr($id, function () {
            return false;
        });

        if(!$itemReload){
            return response()->json(["status" => 0, "message" => __("messages.supplyReloadNotExist")]);
        }
        
        $itemReload->status = 0;
        $itemReload->save(); 

        return response()->json(["status" => 1, "message" => __("messages.supplyReloadDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $itemReload = ItemReload::findOr($id, function () {
            return false;
        });

        if(!$itemReload){
            return response()->json(["status" => 0, "message" => __("messages.supplyReloadNotExist")]);
        }
        
        $itemReload->status = 1;
        $itemReload->save(); 

        return response()->json(["status" => 1, "message" => __("messages.supplyReloadRestored")]);
    } 
}



