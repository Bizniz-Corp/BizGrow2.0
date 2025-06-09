<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\FeedbackController;



// Route Public (Tidak membutuhkan autentikasi)
Route::post('/register', [AuthController::class, 'register']); //API untuk register akun baru
Route::post('/login', [AuthController::class, 'login']); //API untuk login
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']); //API untuk mengirimkan email untuk reset password
Route::post('/reset-password', [AuthController::class, 'resetPassword']); //API untuk reset password setelah mendapatkan email (Laman masukin pass baru)

// Protected Route (Membutuhkan autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); //API untuk logout

    // Tambahkan route lain di sini untuk fitur yang dilindungi
    Route::middleware('role:umkm')->group(function () {
        Route::get('/monthly-profit', [ProductController::class, 'getMonthlyProfit']);
        Route::get('/products', [ProductController::class, 'getAllProduct']);
        Route::post('/products', [ProductController::class, 'addNewProduct']); //API untuk menambah produk baru
        Route::get('/profit', [ProductController::class, 'getMonthlyProfit']);
        Route::post('/input-manual-sales', [SalesController::class, 'storeManualSales']); //Api untuk input manual penjualan
        Route::post('/input-manual-stock', [StockController::class, 'storeManualStockChange']); //API untuk input manual stok
        Route::post('/input-file-sales', [SalesController::class, 'importExcel']); //API untuk input file excel penjualan
        Route::post('/input-file-stock', [StockController::class, 'importExcel']); //API untuk input file excel stok
        Route::get('/sales-history', [SalesController::class, 'getSalesHistory']);
        Route::get('/stocks-history', [StockController::class, 'getStockHistory']);
        Route::get('/sales-history/export/pdf', [SalesController::class, 'exportPdf']);
        Route::get('/stocks-history/export/pdf', [StockController::class, 'exportPdf']);
        Route::get('/profile', [ProfileController::class, 'getProfile']);
        Route::put('/profile/edit', [ProfileController::class, 'updateProfile']);
        Route::put('/profile/delete', [ProfileController::class, 'deleteProfile']);
        Route::post('/profile/edit-password', [ProfileController::class, 'checkPassword']);
        Route::put('/profile/edit-password', [ProfileController::class, 'editPassword']);
        Route::post('/feedback-post', [FeedbackController::class, 'postFeedback']); //API untuk mengirimkan feedback (User)

        // Prediksi Profit
        Route::get('/daily-sales-summary', [SalesController::class, 'getDailySalesSummary']);
        Route::get('/request-profit-predictions', [SalesController::class, 'getProfitPredictions']);

        // Prediksi Demand
        Route::get('/daily-product-demand-summary', [SalesController::class, 'getDailyProductDemandSummary']);
        Route::get('/request-demand-predictions', [SalesController::class, 'getDemandPredictions']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/umkm', [UmkmController::class, 'getDataUmkm']); //API mengambil semua data UMKM untuk Admin
        Route::post('/umkm/delete/{id}', [UmkmController::class, 'deleteUmkm']); //API menghapus UMKM
        Route::get('/umkm-verification', [UmkmController::class, 'getDataUmkmVerification']); //API untuk get data untuk laman Verifikasi UMKM
        Route::post('/umkm-verification-check', [UmkmController::class, 'verifikasiUmkm']); //API untuk verify UMKM
        Route::post('/umkm-verification-reject', [UmkmController::class, 'tolakVerifikasiUmkm']); //API untuk reject UMKM
        Route::get('/feedback', [FeedbackController::class, 'getAllFeedback']); //API untuk mendapatkan semua feedback (Admin)
        Route::get('/umkm-active-inactive', [UmkmController::class, 'getDataUmkmActiveInactive']); //API untuk mendapatkan semua jumlah aktif dan tidak aktif UMKM (admin)
    });
});

