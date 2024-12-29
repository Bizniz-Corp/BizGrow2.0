<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products')); // Blade view
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
