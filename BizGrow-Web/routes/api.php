<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;


// Route Public (Tidak membutuhkan autentikasi)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Route (Membutuhkan autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tambahkan route lain di sini untuk fitur yang dilindungi
    Route::get('/products', [ProductController::class, 'getAllProduct']);
    Route::get('/sales-history', [SalesController::class, 'getSalesHistory']);
    Route::get('/stocks-history', [StockController::class, 'getStockHistory']);
    Route::post('/profile/edit-password', [ProfileController::class, 'checkPassword']);
    Route::put('/profile/edit-password', [ProfileController::class, 'editPassword']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/products', [ApiController::class, 'getAllProducts']);