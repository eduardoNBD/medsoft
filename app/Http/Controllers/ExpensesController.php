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
    Expense
}; 

class ExpensesController extends Controller
{
    public function create(Request $request){  
        $validator = Validator::make(request()->all(), [
            'name' => 'required',  
            'barcode' => 'required',  
        ],
        [
            'name.required' => __('rules.name_required'),  
            'barcode.required' => __('rules.barcode_required'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        } 

        $expense = new Expense;
         
        $expense->name = $request->input("name"); 
        $expense->barcode = $request->input("barcode"); 
        $expense->description = $request->input("description"); 
        $expense->created_by = Auth::user()->id;

        $expense->save(); 
        
        return response()->json(["status" => 1, "message" => __("messages.expenseCreated")]);
    } 

    public function update(Request $request, $id){  
        $expense = Expense::findOr($id, function () {
            return false;
        });

        if(!$expense){
            return response()->json(["status" => 0, "message" => __("messages.expenseNotExist")]);
        }

        if($expense->status == 0)
        {
            return response()->json(["status" => 0, "message" => __("messages.expenseDelete")]);
        }

        $validator = Validator::make(request()->all(), [
            'name' => 'required',  
            'barcode' => 'required',  
        ],
        [
            'name.required' => __('rules.name_required'), 
            'barcode.required' => __('rules.barcode_required'), 
        ]);
        
        if ($validator->fails()){ 
            return response()->json(["status" => 0, "message" => $validator->messages()]);
        }   
        
        $expense->name = $request->input("name"); 
        $expense->barcode = $request->input("barcode"); 
        $expense->description = $request->input("description"); 

        $expense->save();

        return response()->json(["status" => 1, "message" => __("messages.expenseUpdate")]);
    }

    public function list(Request $request){ 
        $expenses = Expense::whereIn("expenses.status", $request->input("status"));

        if($request->input("s")){
            $search = $request->input("s") . '%';
        
            $expenses->where(function ($query) use ($search) {
                $query->where('expenses.name', 'like', $search)
                        ->orWhere('expenses.barcode', 'like', $search)
                        ->orWhere("expenses.description", 'like', $search);
            });
        }
         
        $perPage = 9; 
        $page = $request->input("page") ?: 1; 
    
        $totalExpenses = $expenses->count();
        $totalPages = ceil($totalExpenses / $perPage);

        $page = min($page, $totalPages);

        $fields = [
            "expenses.id",
            "expenses.name",  
            "expenses.description",
            "expenses.barcode", 
            "expenses.status", 
        ];

        $expenses = $expenses->paginate($perPage, $fields, 'expenses', $page); 
        
        return response()->json(["status" => 1, 'items' => $expenses ]);
    } 

    public function delete(Request $request, $id){ 
        $expense = Expense::findOr($id, function () {
            return false;
        });

        if(!$expense){
            return response()->json(["status" => 0, "message" => __("messages.expenseNotExist")]);
        }
        
        $expense->status = 0;
        $expense->save(); 

        return response()->json(["status" => 1, "message" => __("messages.expenseDelete")]);
    } 
    
    public function restore(Request $request, $id){ 
        $expense = Expense::findOr($id, function () {
            return false;
        });

        if(!$expense){
            return response()->json(["status" => 0, "message" => __("messages.expenseNotExist")]);
        }
        
        $expense->status = 1;
        $expense->save(); 

        return response()->json(["status" => 1, "message" => __("messages.expenseRestored")]);
    } 
}



