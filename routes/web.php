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

// Prefix Pegawai (now accessible to admin)
Route::prefix('pegawai')->name('pegawai.')->middleware(['auth', 'role:admin'])->group(function () {
    //Dashboard Pegawai
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Staff order endpoints (AJAX)
    Route::get('orders/pending', [\App\Http\Controllers\Pegawai\OrderController::class, 'pending'])->name('orders.pending');
    Route::post('orders/accept', [\App\Http\Controllers\Pegawai\OrderController::class, 'accept'])->name('orders.accept');
    Route::post('orders/reject', [\App\Http\Controllers\Pegawai\OrderController::class, 'reject'])->name('orders.reject');
    Route::post('orders/complete', [\App\Http\Controllers\Pegawai\OrderController::class, 'complete'])->name('orders.complete');
});

// Route Pelanggan/Guest
Route::prefix('/')
    ->name('pelanggan.')
    ->group(function () {
        Route::get('/', [PelangganController::class, 'index'])
            ->name('home');

        Route::get('/order', [PelangganController::class, 'order'])
            ->name('order');

        Route::get('/order/status', [PelangganController::class, 'status'])->name('order.status');

        Route::get('/transaction', [PelangganController::class, 'transaction'])
            ->name('transaction');
        Route::post('/set-customer', [OrderController::class, 'setCustomer'])
            ->name('set.customer');

        Route::post('/order/qty', [OrderController::class, 'updateQty'])->name('order.qty');
        Route::post('/order/notes', [OrderController::class, 'updateNotes'])->name('order.notes');
        Route::post('/order/add', [OrderController::class, 'addToCart'])->name('order.add');
        Route::get('/order/cart', [OrderController::class, 'cart'])
            ->name('order.cart');
        Route::post('/order/confirm', [OrderController::class, 'confirm'])
            ->name('order.confirm');
        // QRIS payment flow for cashless payments
        Route::get('/payment/qris', [OrderController::class, 'qris'])
            ->name('payment.qris');
        Route::post('/payment/qris/paid', [OrderController::class, 'markPaid'])
            ->name('payment.qris.paid');
        Route::post('/signout', [OrderController::class, 'signOut'])->name('signout');
        Route::delete('/order/remove/{id}', [OrderController::class, 'remove'])
            ->name('order.remove');
    });
