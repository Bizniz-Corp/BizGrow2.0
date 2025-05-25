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
    // Tambahan untuk input stok manual
    public function storeManualStockChange(Request $request)
    {
        $request->validate(
            [
                'product_id' => 'required|exists:products,product_id',
                'changes_quantity' => 'required|integer',
                'changes_date' => 'required|date',
            ],
            [
                'product_id.required' => 'Product Harus Dipilih',
                'product_id.exists' => 'Product tidak ada.',
                'changes_quantity.required' => 'Kutantitas perubahan harus diisi.',
                'changes_quantity.integer' => 'Kuantitas perubahan harus berupa angka.',
                'changes_date.required' => 'Tanggal perubahan harus diisi.',
                'changes_date.date' => 'Tanggal perubahan tidak valid.',
            ]
        );

        $stockChange = StockChange::create([
            'product_id' => $request->product_id,
            'changes_quantity' => $request->changes_quantity,
            'changes_date' => $request->changes_date,
            'total_stock' => StockChange::where('product_id', $request->product_id)->sum('changes_quantity') + $request->changes_quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perubahan stok berhasil disimpan',
            'data' => $stockChange,
        ], 201);
    }

    public function inputStokView()
    {
        return view('stok.stok_input'); // Blade view
    }

    public function inputStokFileView()
    {
        return view('stok.input_stok_file'); // Blade view
    }

    public function inputStokManualView()
    {
        return view('stok.input_stok_manual'); // Blade view
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
