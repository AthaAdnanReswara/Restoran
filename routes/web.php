<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pelanggan.index');
});

Route::get('/order', function () {
    return view('pelanggan.order');
});

Route::get('/transaction', function () {
    return view('pelanggan.transaction');
});
