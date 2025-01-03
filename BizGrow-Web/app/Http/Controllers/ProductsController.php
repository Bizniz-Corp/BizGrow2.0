<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // tampilan dropdown
    public function inputPenjualanManual()
    {
        $products = Product::all(['product_id', 'product_name']);
    
        return view('penjualan.input_penjualan_manual', compact('products'));
    }

    public function inputStokManual()
    {
        $products = Product::all(['product_id', 'product_name']);
    
        return view('stok.input_stok_manual', compact('products'));
    }
}
