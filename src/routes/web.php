<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SucursalController;
use App\Http\Controllers\Admin\TipoMembresiaController;
use App\Http\Controllers\Admin\MiembroController;
use App\Http\Controllers\Admin\MembresiaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Logout Route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Route (Protected)
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('sucursales', SucursalController::class);
        Route::resource('tipos-membresia', TipoMembresiaController::class);
        Route::resource('miembros', MiembroController::class);

        // Rutas para asignar membresías a miembros específicos
        Route::get('miembros/{miembro}/membresias/create', [MembresiaController::class, 'create'])->name('admin.miembros.membresias.create');
        Route::post('miembros/{miembro}/membresias', [MembresiaController::class, 'store'])->name('admin.miembros.membresias.store');

        // Rutas resource para membresías (index, show, edit, update, destroy)
        // 'create' y 'store' se manejan arriba para el contexto de un miembro específico
        Route::resource('membresias', MembresiaController::class)->except(['create', 'store']);
    });
});
