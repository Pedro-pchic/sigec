<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    Route::middleware('can:manage-purchases')->group(function () {
        Route::resource('proveedores', SupplierController::class)
            ->parameters(['proveedores' => 'supplier'])
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        Route::patch('/proveedores/{supplier}/estado', [SupplierController::class, 'toggleStatus'])
            ->name('proveedores.status');

        Route::get('/compras/ordenes/crear', [PurchaseController::class, 'create'])->name('compras.create');
        Route::post('/compras/ordenes', [PurchaseController::class, 'store'])->name('compras.store');
        Route::get('/compras/ordenes/{purchase}/editar', [PurchaseController::class, 'edit'])->name('compras.edit');
        Route::put('/compras/ordenes/{purchase}', [PurchaseController::class, 'update'])->name('compras.update');
        Route::post('/compras/ordenes/{purchase}/enviar', [PurchaseController::class, 'submit'])->name('compras.submit');
        Route::post('/compras/ordenes/{purchase}/cancelar', [PurchaseController::class, 'cancel'])->name('compras.cancel');
    });

    Route::middleware('can:view-purchases')->group(function () {
        Route::get('/compras/ordenes', [PurchaseController::class, 'index'])->name('compras.index');
        Route::get('/compras/ordenes/{purchase}', [PurchaseController::class, 'show'])->name('compras.show');
    });

    Route::post('/compras/ordenes/{purchase}/recibir', [PurchaseController::class, 'receive'])
        ->middleware('can:receive-purchases')
        ->name('compras.receive');

    Route::middleware('can:manage-catalog')->group(function () {
        Route::get('/inventario/existencias', [InventoryController::class, 'index'])
            ->name('inventario.existencias');
        Route::patch('/inventario/existencias/{inventory}/stock-minimo', [InventoryController::class, 'updateMinimumStock'])
            ->name('inventario.minimum-stock');
        Route::get('/inventario/movimientos', [InventoryController::class, 'movements'])
            ->name('inventario.movimientos.index');
        Route::post('/inventario/movimientos', [InventoryController::class, 'storeMovement'])
            ->name('inventario.movimientos.store');

        Route::resource('categorias', CategoryController::class)
            ->parameters(['categorias' => 'category'])
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        Route::patch('/categorias/{category}/estado', [CategoryController::class, 'toggleStatus'])->name('categorias.status');

        Route::resource('productos', ProductController::class)
            ->parameters(['productos' => 'product'])
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        Route::patch('/productos/{product}/estado', [ProductController::class, 'toggleStatus'])->name('productos.status');
    });
});
