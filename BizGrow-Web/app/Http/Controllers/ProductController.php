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

    public function addNewProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();
        $umkmId = DB::table('umkms')->where('user_id', $userId)->value('umkm_id');

        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->product_quantity = $request->input('product_quantity');
        $product->umkm_id = $umkmId;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    public function getMonthlyProfit()
    {
        $currentMonth = 12; // Bulan saat ini
        $currentYear = 2024;  // Tahun saat ini

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

}
