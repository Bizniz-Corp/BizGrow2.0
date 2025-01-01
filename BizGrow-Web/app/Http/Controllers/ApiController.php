<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
     // Endpoint untuk fetch semua produk
    public function getAllProducts()
    {
        try {
            $products = Product::all();
            return response()->json([
                'success' => true,
                'data' => $products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Endpoint untuk fetch satu produk berdasarkan ID
    public function getProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
                'error' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Product not found' : $e->getMessage(),
            ], 404);
        }
    }

    public function getMonthlyProfit()
    {
        $currentMonth = Carbon::now()->month; // Bulan saat ini
        $currentYear = Carbon::now()->year;  // Tahun saat ini

        // Hitung total pembelian pada bulan ini
        $totalPembelian = DB::table('purchase_transactions')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');

        // Hitung total penjualan pada bulan ini
        $totalPenjualan = DB::table('sales_transactions')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');

        return response()->json([
            'success' => true,
            'data' => [
                'total_pembelian' => $totalPembelian,
                'total_penjualan' => $totalPenjualan,
            ],
        ]);
    }
}
