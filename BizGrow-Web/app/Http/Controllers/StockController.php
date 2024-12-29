<?php

namespace App\Http\Controllers;

use App\Models\StockChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function getStockHistory()
    {
        $userId = Auth::id();

        $stockHistory = StockChange::join('products', 'stock_changes.product_id', '=', 'products.product_id')
            ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', $userId)
            ->select(
                'stock_changes.stock_change_id',
                'products.product_name',
                'stock_changes.changes_date',
                'stock_changes.changes_quantity',
                'stock_changes.total_stock'
            )
            ->orderBy('stock_changes.changes_date', 'desc')
            ->orderBy('products.product_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $stockHistory,
        ], 200);

    }
}
