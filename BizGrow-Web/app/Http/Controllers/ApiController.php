<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseTransaction;
use App\Models\StockChange;
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

}
