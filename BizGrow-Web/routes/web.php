<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('landing_page');
})->name('landing');

Route::get('/signin', function () {
    return view('signin'); // Pastikan nama view sesuai dengan file blade
});

Route::get('/forgot-password', function () {
    return view('autentikasi.forgot-password');
})->name('password.request');

Route::get('/otp', function () {
    return view('autentikasi.otp');
})->name('otp');

Route::get('/login', [AuthController::class, 'signinView'])->name('login');
Route::get('/register', [AuthController::class, 'signupView'])->name('register');
// Route::get('/sign-out', [AuthController::class, 'signoutView'])->name('signout');

// Route::get('/input_penjualan', function () {
//     return view('penjualan.penjualan_input');
// })->name('penjualan.input');

Route::get('/home', [ProductController::class, 'home'])->name('home');

Route::prefix('penjualan')->group(function () {
    Route::get('/input', [SalesController::class, 'inputPenjualanView'])->name('penjualan.input');
    Route::get('/input-file', [SalesController::class, 'inputPenjualanFileView'])->name('penjualan.inputFile');
    Route::get('/input-manual', [SalesController::class, 'inputPenjualanManualView'])->name('penjualan.inputManual');
    Route::get('/riwayat', [SalesController::class, 'riwayatView'])->name('penjualan.riwayat');
    Route::get('/demand', [SalesController::class, 'demand'])->name('penjualan.demand');
    Route::get('/profit', [SalesController::class, 'profit'])->name('penjualan.profit');
});

Route::prefix('stok')->group(function () {
    Route::get('/input', [StockController::class, 'inputStokView'])->name('stok.input');
    Route::get('/input-file', [StockController::class, 'inputStokFileView'])->name('stok.inputFile');
    Route::get('/input-manual', [StockController::class, 'inputStokManualView'])->name('stok.inputManual');
    Route::get('/riwayat', [StockController::class, 'riwayatView'])->name('stok.riwayat');
    Route::get('/bufferstok', [StockController::class, 'bufferstokView'])->name('stok.bufferstok');
});

Route::prefix('profil')->group(function () {
    Route::get('/', [ProfileController::class, 'profilView'])->name('profil.profil');
    Route::get('/edit', [ProfileController::class, 'profilEditView'])->name('profil.edit');
    Route::get('/edit-password', [ProfileController::class, 'profilEditPasswordView'])->name('profil.editPassword');
});

// ROUTING DENGAN MIDDLEWARE HARUS AUTHENTICATION
// Route::middleware([Authenticate::class])->group(function () {
//     Route::get('/home', [ProductController::class, 'home'])->name('home');
//     Route::prefix('penjualan')->group(function () {
//         Route::get('/input', [SalesController::class, 'inputPenjualanView'])->name('penjualan.input');
//         Route::get('/input-file', [SalesController::class, 'inputPenjualanFileView'])->name('penjualan.inputFile');
//         Route::get('/input-manual', [SalesController::class, 'inputPenjualanManualView'])->name('penjualan.inputManual');
//         Route::get('/riwayat', [SalesController::class, 'riwayatView'])->name('penjualan.riwayat');
//         Route::get('/demand', [SalesController::class, 'demand'])->name('penjualan.demand');
//         Route::get('/profit', [SalesController::class, 'profit'])->name('penjualan.profit');
//     });

//     Route::prefix('stok')->group(function () {
//         Route::get('/input', [StockController::class, 'inputStokView'])->name('stok.input');
//         Route::get('/input-file', [StockController::class, 'inputStokFileView'])->name('stok.inputFile');
//         Route::get('/input-manual', [StockController::class, 'inputStokManualView'])->name('stok.inputManual');
//         Route::get('/riwayat', [StockController::class, 'riwayatView'])->name('stok.riwayat');
//         Route::get('/bufferstok', [StockController::class, 'bufferstokView'])->name('stok.bufferstok');
//     });

//     Route::prefix('profil')->group(function () {
//         Route::get('/', [ProfileController::class, 'profilView'])->name('profil.profil');
//         Route::get('/edit', [ProfileController::class, 'profilEditView'])->name('profil.edit');
//         Route::get('/edit-password', [ProfileController::class, 'profilEditPasswordView'])->name('profil.editPassword');
//     });
// });


