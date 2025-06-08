<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax() || $request->is('api/*')) {
                return response()->json(['message' => __("messages.login")], 401);
            }

            return redirect('login');
        }

        $user     = Auth::user(); 
        $redirect = $user->role == 3 ? "/" : 'dashboard';

        if (!in_array($user->role, $roles)) {
            if ($request->expectsJson() || $request->ajax() || $request->is('api/*')) {
                return response()->json(['message' => 'without Authorize'], 401);
            }

            return redirect($redirect);
        } 

        return $next($request);
    }

}
