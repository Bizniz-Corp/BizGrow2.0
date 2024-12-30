<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products')); // Blade view
    }

    public function home()
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

    public function history()
    {
        $products = Product::all();
        return view('penjualan.penjualan_history', compact('products')); // Blade view
    }
}
