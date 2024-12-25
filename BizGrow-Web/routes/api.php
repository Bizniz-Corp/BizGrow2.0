<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route Public (Tidak membutuhkan autentikasi)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Route (Membutuhkan autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tambahkan route lain di sini untuk fitur yang dilindungi
    Route::get('/profile', [ApiController::class, 'getAllProducts']);
    Route::get('/products', [ApiController::class, 'getAllProducts']);
    Route::get('/sales-history', [ApiController::class, 'getSalesHistory']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/products', [ApiController::class, 'getAllProducts']);