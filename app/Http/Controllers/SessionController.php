<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Models\Branch;

class SessionController extends Controller{

    public function changeLanguage($locale){
        if (! in_array($locale, ['en', 'es'])) {
            abort(400);
        }
        
        session(['locale' => $locale]);
      
        return redirect()->back();
    } 
}