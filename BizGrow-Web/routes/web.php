<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ProductController::class, 'home'])->name('home');


Route::get('/landing', function () {
    return view('landing_page');
})->name('landing.page');

Route::get('/input_penjualan', function () {
    return view('penjualan.penjualan_input');
})->name('penjualan.input');


Route::get('/riwayat_penjualan', function () {
    return view('penjualan.penjualan_history');
})->name('penjualan.riwayat');

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

Route::get('/profil/edit-password', function () {
    return view('profil.edit_password');
})->name('profil.edit.password');

route::get('/signout', function () {
    return view('/autentikasi.signin');
})->name('signout');

route::get('/sign-in', function () {
    return view('/autentikasi.signin');
})->name('sign.in');

route::get('/sign-up', function () {
    return view('/autentikasi.signup');
})->name('sign.in');

