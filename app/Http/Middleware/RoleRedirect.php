<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class RoleRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('super-admin')) {
                return redirect()->route('admin');
            } elseif ($user->hasRole('aspirante-alcaldia')) {
                return redirect()->route('home');
            } elseif ($user->hasRole('aspirante-concejo')) {
                return redirect()->route('homeConcejal');
            } elseif ($user->hasRole('lider')) {
                return redirect()->route('homeLider');
            }
        }

        return $next($request);
    }
}
