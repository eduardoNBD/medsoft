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
    ExpenseRecord
}; 

class ExpensesRecordsController extends Controller
{
    public function create(Request $request){  
        $data = request()->all(); 
        
        if (isset($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }
        
        $validator = Validator::make($data, [
            'medical_unit' => 'required',  
            'date' => 'required', 
            'payment_method' => 'required',  
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',  
        ], [
            'medical_unit.required' => __('rules.medical_unit_required'),  
            'date.required' => __('rules.date_required'),   
            'payment_method.required' => __('rules.payment_method_required'),   
            'items.required' => __('rules.items_required'), 
            'items.array' => __('rules.items_array'), 
            'items.*.name.required' => __('rules.name_required'),
            'items.*.qty.required' => __('rules.qty_required'),
            'items.*.qty.integer' => __('rules.qty_invalid'),
            'items.*.qty.min' => __('rules.qty_min'),
            'items.*.price.required' => __('rules.price_required'),
            'items.*.price.numeric' => __('rules.price_invalid'),
            'items.*.price.min' => __('rules.price_min'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $expenseRecord = new ExpenseRecord;
         
        $expenseRecord->medical_unit_id = $request->input("medical_unit"); 
        $expenseRecord->notes = $request->input("notes"); 
        $expenseRecord->date = $request->input("date"); 
        $expenseRecord->payment_method = $request->input("payment_method"); 
        $expenseRecord->items = $request->input("items"); 
        $expenseRecord->created_by = Auth::user()->id;

        $expenseRecord->save(); 
        
        return response()->json(["status" => 1, "message" => __("messages.expenseRecordCreated")]);
    } 

    public function update(Request $request, $id){  
        $expenseRecord = ExpenseRecord::findOr($id, function () {
            return false;
        });

        if(!$expenseRecord){
            return response()->json(["status" => 0, "message" => __("messages.expenseRecordNotExist")]);
        }

        if($expenseRecord->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.expenseRecordDelete")]);
        }

        $data = request()->all(); 
        
        if (isset($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }
        
        $validator = Validator::make($data, [
            'medical_unit' => 'required',  
            'date' => 'required',  
            'payment_method' => 'required',  
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',  
        ], [
            'medical_unit.required' => __('rules.medical_unit_required'),  
            'date.required' => __('rules.date_required'),   
            'payment_method.required' => __('rules.payment_method_required'),   
            'items.required' => __('rules.items_required'), 
            'items.array' => __('rules.items_array'), 
            'items.*.name.required' => __('rules.name_required'),
            'items.*.qty.required' => __('rules.qty_required'),
            'items.*.qty.integer' => __('rules.qty_invalid'),
            'items.*.qty.min' => __('rules.qty_min'),
            'items.*.price.required' => __('rules.price_required'),
            'items.*.price.numeric' => __('rules.price_invalid'),
            'items.*.price.min' => __('rules.price_min'), // Nuevo mensaje si 'price' es menor a 0.01
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }  
        
        $expenseRecord->medical_unit_id = $request->input("medical_unit"); 
        $expenseRecord->notes = $request->input("notes"); 
        $expenseRecord->date = $request->input("date"); 
        $expenseRecord->payment_method = $request->input("payment_method"); 
        $expenseRecord->items = $request->input("items"); 
        $expenseRecord->created_by = Auth::user()->id;

        $expenseRecord->save(); 

        return response()->json(["status" => 1, "message" => __("messages.expenseRecordUpdate")]);
    }

    public function list(Request $request)
    { 
        $expensesRecords = ExpenseRecord::leftJoin('medical_units', 'expenses_records.medical_unit_id', '=', 'medical_units.id')
                                        ->whereIn("expenses_records.status", $request->input("status"));

        if ($request->input("s")) {
            $search = $request->input("s") . '%';

            $expensesRecords->where(function ($query) use ($search) {
                $query->where('expenses_records.notes', 'like', $search)
                    ->orWhere('medical_units.name', 'like', $search);
            });
        }
            
        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
        
        $totalExpensesRecords = $expensesRecords->count();
        $totalPages = ceil($totalExpensesRecords / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "expenses_records.id",   
            "expenses_records.notes",
            "expenses_records.date", 
            "expenses_records.status", 
            "expenses_records.items",  
            "medical_units.name"
        ];

        $expensesRecords = $expensesRecords->paginate($perPage, $fields, 'expenses_records', $page);
 
        $expensesRecords->getCollection()->transform(function ($record) { 
            $items = json_decode($record->items, true);

            $record->total = collect($items)->sum(function ($item) {
                return $item['qty'] * $item['price'];
            });

            return $record;
        });

        return response()->json(["status" => 1, 'items' => $expensesRecords]);
    }


    public function delete(Request $request, $id){ 
        $expenseRecord = ExpenseRecord::findOr($id, function () {
            return false;
        });

        if(!$expenseRecord){
            return response()->json(["status" => 0, "message" => __("messages.expenseRecordNotExist")]);
        }
        
        $expenseRecord->status = 0;
        $expenseRecord->save(); 

        return response()->json(["status" => 1, "message" => __("messages.expenseRecordDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $expenseRecord = ExpenseRecord::findOr($id, function () {
            return false;
        });

        if(!$expenseRecord){
            return response()->json(["status" => 0, "message" => __("messages.expenseRecordNotExist")]);
        }
        
        $expenseRecord->status = 1;
        $expenseRecord->save(); 

        return response()->json(["status" => 1, "message" => __("messages.expenseRecordRestored")]);
    } 
}



