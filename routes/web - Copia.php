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

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::middleware(['permission:manage_users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    // Client Management
    Route::middleware(['permission:manage_clients'])->group(function () {
        Route::resource('clients', ClientController::class);
    });

    // Barber Management
    Route::middleware(['permission:manage_barbers'])->group(function () {
        Route::resource('barbers', BarberController::class);
    });

    // Service Management
    Route::middleware(['permission:manage_services'])->group(function () {
        Route::resource('services', ServiceController::class);
    });

    // Product Management
    Route::middleware(['permission:manage_products'])->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Appointment Management
    Route::middleware(['permission:manage_appointments'])->group(function () {
        Route::resource('appointments', AppointmentController::class);
    });

    // Sales and PDV
    Route::middleware(['permission:manage_sales'])->group(function () {
        Route::resource('sales', SaleController::class);
        Route::get('pdv', [SaleController::class, 'pdv'])->name('pdv');
        Route::post('pdv/sale', [SaleController::class, 'processSale'])->name('pdv.sale');
    });

    // Cash Register Management
    Route::middleware(['permission:manage_cash'])->group(function () {
        Route::resource('cash-registers', CashRegisterController::class);
        Route::post('cash-registers/open', [CashRegisterController::class, 'open'])->name('cash-registers.open');
        Route::post('cash-registers/close/{cashRegister}', [CashRegisterController::class, 'close'])->name('cash-registers.close');
    });
});
