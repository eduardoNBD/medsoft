<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\{
    User,
    Specialty,
    MedicalUnit
};

class NoAuthController extends Controller{

    public function index(){
        if (Auth::check()) { 
            return redirect(config('app.url').'/dashboard');
        }

        return view("noAuth.login");
    }

    public function register(){
        if (Auth::check()) { 
            return redirect(config('app.url').'/dashboard');
        }

        $specialties  = Specialty::select(["id","name"])->get();
        $doctors      = User::select(["doctors.id","users.id as user_id","first_name","last_name"])->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')->where(["role" => 2])->get();
        $medicalUnits = MedicalUnit::select(["id","name"])->get();
        
        return view("noAuth.register",[
            'doctors' => $doctors,  
            'specialties' => $specialties,  
            'medicalUnits' => $medicalUnits,  
        ]);
    }

    public function forgetPassword(){
        if (Auth::check()) { 
            return redirect(config('app.url').'/dashboard');
        }
        
        return view("noAuth.forgetPassword");
    }

    public function resetPassword($token){
        if (Auth::check()) { 
            return redirect('/dashboard');
        }
        
        $passwordResetToken = DB::table('password_reset_tokens')
        ->where('token', $token)
        ->first();

        if(!$passwordResetToken){
            return redirect('/login?msg='.__("messages.invalid_token")."_error");
        }

        return view("noAuth.reset", ['token' => $token]);
    }
}