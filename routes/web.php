<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal - redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::post('/validar-registro', [LoginController::class, 'registro'])->name('validar-registro');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para verificar email (AJAX)
Route::post('/check-email', [LoginController::class, 'checkEmail'])->name('check-email');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/privada', [LoginController::class, 'privada'])->name('privada');
    
    

   
});

// Ruta para manejar usuarios no autenticados que intentan acceder a rutas protegidas
Route::fallback(function () {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
    }
    abort(404);
});