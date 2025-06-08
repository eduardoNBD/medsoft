<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {  
        if ($request->headers->get('sec-fetch-mode') === 'cors' &&
            $request->headers->get('sec-fetch-dest') === 'empty' &&
            $request->headers->get('accept') === '*/*') {
            abort(response()->json(['message' => 'Unauthorized'], 401));
        }
    
        return route('login');
    }
}
