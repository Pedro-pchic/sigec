<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SaleController;
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

    Route::middleware('can:manage-commercial')->group(function () {
        Route::resource('clientes', CustomerController::class)
            ->parameters(['clientes' => 'customer'])
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        Route::patch('/clientes/{customer}/estado', [CustomerController::class, 'toggleStatus'])
            ->name('clientes.status');

        Route::get('/clientes/{customer}/direcciones/crear', [AddressController::class, 'create'])
            ->name('clientes.direcciones.create');
        Route::post('/clientes/{customer}/direcciones', [AddressController::class, 'store'])
            ->name('clientes.direcciones.store');
        Route::get('/clientes/{customer}/direcciones/{address}/editar', [AddressController::class, 'edit'])
            ->scopeBindings()
            ->name('clientes.direcciones.edit');
        Route::put('/clientes/{customer}/direcciones/{address}', [AddressController::class, 'update'])
            ->scopeBindings()
            ->name('clientes.direcciones.update');
        Route::delete('/clientes/{customer}/direcciones/{address}', [AddressController::class, 'destroy'])
            ->scopeBindings()
            ->name('clientes.direcciones.destroy');

        Route::get('/cotizaciones', [QuoteController::class, 'index'])->name('cotizaciones.index');
        Route::get('/cotizaciones/crear', [QuoteController::class, 'create'])->name('cotizaciones.create');
        Route::post('/cotizaciones', [QuoteController::class, 'store'])->name('cotizaciones.store');
        Route::get('/cotizaciones/{quote}/editar', [QuoteController::class, 'edit'])->name('cotizaciones.edit');
        Route::put('/cotizaciones/{quote}', [QuoteController::class, 'update'])->name('cotizaciones.update');
        Route::post('/cotizaciones/{quote}/enviar', [QuoteController::class, 'send'])->name('cotizaciones.send');
        Route::post('/cotizaciones/{quote}/aceptar', [QuoteController::class, 'accept'])->name('cotizaciones.accept');
        Route::post('/cotizaciones/{quote}/rechazar', [QuoteController::class, 'reject'])->name('cotizaciones.reject');
        Route::post('/cotizaciones/{quote}/pedido', [OrderController::class, 'storeFromQuote'])
            ->name('cotizaciones.pedido.store');
        Route::get('/cotizaciones/{quote}', [QuoteController::class, 'show'])->name('cotizaciones.show');

        Route::get('/pedidos', [OrderController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/crear', [OrderController::class, 'create'])->name('pedidos.create');
        Route::post('/pedidos', [OrderController::class, 'store'])->name('pedidos.store');
        Route::get('/pedidos/{order}/editar', [OrderController::class, 'edit'])->name('pedidos.edit');
        Route::put('/pedidos/{order}', [OrderController::class, 'update'])->name('pedidos.update');
        Route::post('/pedidos/{order}/confirmar', [OrderController::class, 'confirm'])->name('pedidos.confirm');
        Route::post('/pedidos/{order}/cancelar', [OrderController::class, 'cancel'])->name('pedidos.cancel');
        Route::post('/pedidos/{order}/venta', [OrderController::class, 'sell'])->name('pedidos.sale.store');
        Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('pedidos.show');

        Route::get('/ventas', [SaleController::class, 'index'])->name('ventas.index');
        Route::get('/ventas/{sale}', [SaleController::class, 'show'])->name('ventas.show');
    });

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
