<?php

namespace App\Http\Controllers;

use App\Models\StockChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function getStockHistory(Request $request)
    {
        $userId = Auth::id();
        $perPage = $request->query('per_page', 10);
        $productName = $request->query('product_name');

        $query = StockChange::join('products', 'stock_changes.product_id', '=', 'products.product_id')
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
            ->orderBy('products.product_name', 'asc');

        // Tambahkan filter berdasarkan nama produk jika ada
        if ($productName) {
            $query->where('products.product_name', 'like', '%' . $productName . '%');
        }

        // Tambahkan filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query->whereBetween('stock_changes.changes_date', [$startDate, $endDate]);
        }

        // Pagination
        $stockHistory = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $stockHistory->items(),
            'pagination' => [
                'current_page' => $stockHistory->currentPage(),
                'last_page' => $stockHistory->lastPage(),
                'per_page' => $stockHistory->perPage(),
                'total' => $stockHistory->total(),
            ],
        ], 200);

    }

    public function inputStokView()
    {
        return view('stok.stok_input'); // Blade view
    }

    public function inputStokFileView()
    {
        return view('penjualan.input_stok_file'); // Blade view
    }

    public function inputStokManualView()
    {
        return view('penjualan.input_stok_manual'); // Blade view
    }

    public function riwayatView()
    {
        return view('stok.stok_history'); // Blade view
    }

    public function bufferstokView()
    {
        return view('stok.stok_prediksi_buffer_stok'); // Blade view
    }
}
