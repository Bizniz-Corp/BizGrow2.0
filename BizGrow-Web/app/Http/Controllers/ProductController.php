<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $userId = Auth::id();
        $products = Product::join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', $userId)
            ->select('products.product_id', 'products.product_name', 'products.product_quantity', 'products.price')
            ->orderBy('products.product_name', 'asc')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
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

    public function home()
    {
        // $currentMonth = Carbon::now()->month; // Bulan saat ini
        // $currentYear = Carbon::now()->year;  // Tahun saat ini

        $currentMonth = 12; // Bulan Desember
        $currentYear = 2024;  // Tahun 2024

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

        return view('home', [
            'totalPembelian' => $totalPembelian,
            'totalPenjualan' => $totalPenjualan,
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return view('products.show', compact('product')); // Blade view
    }

}
