<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PermissionController;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Product Management
    Route::middleware(['permission:view-products'])->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    });
    Route::middleware(['permission:create-products'])->group(function () {
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
    });
    Route::middleware(['permission:edit-products'])->group(function () {
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    });
    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy')
        ->middleware('permission:delete-products');

    // User Management
    Route::middleware(['permission:view-users'])->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });
    Route::middleware(['permission:create-users'])->group(function () {
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
    });
    Route::middleware(['permission:edit-users'])->group(function () {
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('permission:delete-users');

    // Role Management
    Route::middleware(['permission:manage-roles'])->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Client Management
    Route::middleware(['permission:view-clients'])->group(function () {
        Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    });
    Route::middleware(['permission:create-clients'])->group(function () {
        Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    });
    Route::middleware(['permission:edit-clients'])->group(function () {
        Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    });
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])
        ->name('clients.destroy')
        ->middleware('permission:delete-clients');

    // Service Management
    Route::middleware(['permission:view-services'])->group(function () {
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');
    });
    Route::middleware(['permission:create-services'])->group(function () {
        Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('services', [ServiceController::class, 'store'])->name('services.store');
    });
    Route::middleware(['permission:edit-services'])->group(function () {
        Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
    });
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])
        ->name('services.destroy')
        ->middleware('permission:delete-services');

    // Barber Management
    Route::middleware(['permission:view-services'])->group(function () {
        Route::get('barbers', [BarberController::class, 'index'])->name('barbers.index');
        Route::get('barbers/{barber}', [BarberController::class, 'show'])->name('barbers.show');
    });
    Route::middleware(['permission:create-services'])->group(function () {
        Route::get('barbers/create', [BarberController::class, 'create'])->name('barbers.create');
        Route::post('barbers', [BarberController::class, 'store'])->name('barbers.store');
    });
    Route::middleware(['permission:edit-services'])->group(function () {
        Route::get('barbers/{barber}/edit', [BarberController::class, 'edit'])->name('barbers.edit');
        Route::put('barbers/{barber}', [BarberController::class, 'update'])->name('barbers.update');
    });
    Route::delete('barbers/{barber}', [BarberController::class, 'destroy'])
        ->name('barbers.destroy')
        ->middleware('permission:delete-services');

    // Appointment Management
    Route::middleware(['permission:view-appointments'])->group(function () {
        Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });
    Route::middleware(['permission:create-appointments'])->group(function () {
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    });
    Route::middleware(['permission:edit-appointments'])->group(function () {
        Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    });
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('appointments.destroy')
        ->middleware('permission:delete-appointments');

    // PDV Routes
    Route::middleware(['permission:make-sale'])->group(function () {
        Route::get('pdv', [SaleController::class, 'pdv'])->name('pdv');
        Route::post('pdv/sale', [SaleController::class, 'processSale'])->name('pdv.sale');
    });

    // Cash Register Management
    Route::middleware(['permission:open-cashier'])->post('cash-registers/open', [CashRegisterController::class, 'open'])->name('cash-registers.open');
    Route::middleware(['permission:close-cashier'])->post('cash-registers/close/{cashRegister}', [CashRegisterController::class, 'close'])->name('cash-registers.close');
    Route::middleware(['permission:make-withdrawal'])->post('cash-registers/withdraw', [CashRegisterController::class, 'withdraw'])->name('cash-registers.withdraw');
    Route::middleware(['permission:make-reinforcement'])->post('cash-registers/reinforcement', [CashRegisterController::class, 'reinforcement'])->name('cash-registers.reinforcement');

    // Permission Management
    Route::middleware(['permission:manage-permissions'])->group(function () {
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
});
