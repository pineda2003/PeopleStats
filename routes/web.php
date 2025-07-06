<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::post('/validar-registro', [LoginController::class, 'registro'])->name('validar-registro');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/check-email', [LoginController::class, 'checkEmail'])->name('check-email');

// Rutas protegidas por autenticación y rol (CAMBIO IMPORTANTE)
// Cambié 'role:1' por 'role:Super Admin' etc.
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Solo usuarios con rol "Super Admin" pueden acceder
    Route::get('/admin', [UserController::class, 'index'])->name('admin');
    
    // CRUD de usuarios (solo admin)
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    
    Route::get('/analytics', function () {
        return view('analytics.analytics');
    })->name('analytics');
});

Route::middleware(['auth', 'role:Candidato Alcalde'])->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('home');
});

Route::middleware(['auth', 'role:Candidato Concejal'])->group(function () {
    Route::get('/homeConcejal', [UserController::class, 'homeConcejal'])->name('homeConcejal');
});

Route::middleware(['auth', 'role:Líder Comunitario'])->group(function () {
    Route::get('/homeLider', [UserController::class, 'homeLider'])->name('homeLider');
});

Route::fallback(function () {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
    }
    abort(404);
});