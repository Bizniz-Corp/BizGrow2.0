<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;


// Route Public (Tidak membutuhkan autentikasi)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/logout', function (Request $request) {
    // logika hapus/blacklist token di sini (jika perlu)
    return response()->json(['message' => 'Logged out']);
});


// Protected Route (Membutuhkan autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tambahkan route lain di sini untuk fitur yang dilindungi
    Route::middleware('role:umkm')->group(function () {
        Route::get('/monthly-profit', [ProductController::class, 'getMonthlyProfit']);
        Route::get('/products', [ProductController::class, 'getAllProduct']);
        Route::get('/profit', [ProductController::class, 'getMonthlyProfit']);
        Route::get('/sales-history', [SalesController::class, 'getSalesHistory']);
        Route::get('/stocks-history', [StockController::class, 'getStockHistory']);
        Route::get('/profile', [ProfileController::class, 'getProfile']);
        Route::put('/profile/edit', [ProfileController::class, 'updateProfile']);
        Route::put('/profile/delete', [ProfileController::class, 'deleteProfile']);
        Route::post('/profile/edit-password', [ProfileController::class, 'checkPassword']);
        Route::put('/profile/edit-password', [ProfileController::class, 'editPassword']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/umkm', [UmkmController::class, 'getDataUmkm']);
        Route::post('/umkm/delete/{id}', [UmkmController::class, 'deleteUmkm']);
        Route::get('/umkm-verification', [UmkmController::class, 'getDataUmkmVerification']);
        Route::post('/umkm-verification/{id}', [UmkmController::class, 'verifyUmkm']);
    });
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'check.blacklist'])->get('/home', function () {
    return response()->json(['message' => 'Selamat datang di halaman Home']);
});

Route::middleware('auth:sanctum')->post('/logout', function () {
    $token = request()->bearerToken();

    if ($token) {
        DB::table('blacklisted_tokens')->insert([
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json(['message' => 'Logout berhasil'], 200);
});


