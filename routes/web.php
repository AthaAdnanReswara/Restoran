<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('pelanggan.index');
});

//Routes Login dan Logout
Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//Prefix Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function (){
    //Dashboard Admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Menu Resource
    Route::resource('menu', MenuController::class);
    //Pegawai Resource
    Route::resource('pegawai', PegawaiController::class);
});