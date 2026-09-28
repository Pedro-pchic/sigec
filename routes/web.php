<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('usuarios', UserController::class)
            ->parameters(['usuarios' => 'user'])
            ->only(['index', 'create', 'store', 'edit', 'update']);
        Route::patch('/usuarios/{user}/estado', [UserController::class, 'toggleStatus'])->name('usuarios.status');
    });

    Route::middleware('can:manage-employees')->group(function () {
        Route::resource('empleados', EmployeeController::class)
            ->parameters(['empleados' => 'employee'])
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        Route::patch('/empleados/{employee}/estado', [EmployeeController::class, 'toggleStatus'])->name('empleados.status');
    });
});
