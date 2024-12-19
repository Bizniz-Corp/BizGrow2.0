<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/input_penjualan', function () {
    return view('penjualan.penjualan_input');
})->name('penjualan.input');


Route::get('/riwayat_penjualan', 
[ProductController::class, 'history'])->name('penjualan.riwayat');

Route::get('/demand', function () {
    return view('penjualan.penjualan_prediksi_demand');
})->name('penjualan.demand');

Route::get('/profit', function () {
    return view('penjualan.profit');
})->name('penjualan.profit');

Route::get('/input_stok', function () {
    return view('stok.stok_input');
})->name('stok.input');

Route::get('/riwayat_stok', function () {
    return view('stok.stok_history');
})->name('stok.riwayat');

Route::get('/buffer_stok', function () {
    return view('/stok.stok_prediksi_buffer_stok');
})->name('stok.bufferstok');

Route::get('/profil', function () {
    return view('profil.profile');
})->name('profil');

route::get('/signout', function () {
    return view('/autentikasi.signin');
})->name('signout');

