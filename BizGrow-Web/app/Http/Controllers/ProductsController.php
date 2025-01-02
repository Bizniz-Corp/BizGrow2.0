<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // tampilan dropdown
    public function inputManual()
    {
        $products = Product::all(['product_id', 'product_name']);
    
        return view('penjualan.input_penjualan_manual', compact('products'));
    }

    // store data ke database
    public function store(Request $request)
    {
    $validated = $request->validate([
        'product_id' => 'required|integer|exists:products,product_id',
        'product_quantity' => 'required|integer|min:1',
        'price_per_item' => 'required|integer|min:1',
        // 'umkm_id' => 'required|integer|exists:umkms,id',
    ]);

    DB::table('sales_transaction')->insert([
        'product_id' => $validated['product_id'],
        'product_quantity' => $validated['product_quantity'],
        'price' => $validated['price'],
        // 'umkm_id' => $validated['umkm_id'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Sales transaction added successfully!');
    }
    
}
