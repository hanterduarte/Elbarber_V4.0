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

    // Product Management
    Route::resource('products', ProductController::class);

    // User Management
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Client Management
    Route::resource('clients', ClientController::class);

    // Barber Management
    Route::resource('barbers', BarberController::class);
    Route::delete('barbers/{barber}/remove-photo', [BarberController::class, 'removePhoto'])->name('barbers.remove-photo');

    // Service Management
    Route::resource('services', ServiceController::class);

    // Appointment Management
    Route::resource('appointments', AppointmentController::class);

    // Sales and PDV
    Route::resource('sales', SaleController::class);
    Route::get('pdv', [SaleController::class, 'pdv'])->name('pdv');
    Route::post('pdv/sale', [SaleController::class, 'processSale'])->name('pdv.sale');

    // Cash Register Management
    Route::resource('cash-registers', CashRegisterController::class);
    Route::post('cash-registers/open', [CashRegisterController::class, 'open'])->name('cash-registers.open');
    Route::post('cash-registers/close/{cashRegister}', [CashRegisterController::class, 'close'])->name('cash-registers.close');
    Route::post('cash-registers/withdraw', [CashRegisterController::class, 'withdraw'])->name('cash-registers.withdraw');
});
