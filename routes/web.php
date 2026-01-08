<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('dashboard', [DashboardController::class, 'login'])->name('dashboard');

});