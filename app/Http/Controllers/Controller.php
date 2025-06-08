<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request; 

class Controller extends BaseController{
    use AuthorizesRequests, ValidatesRequests;
    
    public function __construct()
    { 
        require getcwd()."/config/menu.php"; 

        view()->share('_', [
            'menu' => $menu,  
            'menuBottom' => $menuBottom,  
            'routes' => $routes,
            'url' => "/".Request::path(),
            'baseURL' => config('app.url'), 
        ]);
    }

    public function print_array($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
