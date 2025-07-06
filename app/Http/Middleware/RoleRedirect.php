<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            switch ($user->rol_id) { // <-- Cambia 'role' por 'rol_id'
                case 1:
                    return redirect()->route('admin');
                case 2:
                    return redirect()->route('home');
                case 3:
                    return redirect()->route('homeConcejal');
                case 4:
                    return redirect()->route('homeLider');
                    
            }
        }
        
        return $next($request);
    }
}