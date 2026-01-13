<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\TabelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pelanggan\OrderController;
use App\Http\Controllers\Pelanggan\PelangganController;
use Illuminate\Support\Facades\Route;

//Routes Login dan Logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//Prefix Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    //Dashboard Admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Menu Resource
    Route::resource('menu', MenuController::class);
    //Pegawai Resource
    Route::resource('pegawai', PegawaiController::class);
    //Tabel Resource
    Route::resource('table', TabelController::class);
});

// Prefix Pegawai
Route::prefix('pegawai')->name('pegawai.')->middleware(['auth', 'role:pegawai'])->group(function () {
    //Dashboard Pegawai
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route Pelanggan/Guest
Route::prefix('/')
    ->name('pelanggan.')
    ->group(function () {
        Route::get('/', [PelangganController::class, 'index'])
            ->name('home');

        Route::get('/order', [PelangganController::class, 'order'])
            ->name('order');

        Route::get('/transaction', [PelangganController::class, 'transaction'])
            ->name('transaction');
        Route::post('/set-customer', [OrderController::class, 'setCustomer'])
            ->name('set.customer');
        Route::post('/order/qty', [OrderController::class, 'updateQty'])->name('order.qty');
        Route::post('/order/add', [OrderController::class, 'addToCart'])->name('order.add');
    });
