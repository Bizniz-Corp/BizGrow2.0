<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function getSalesHistory(Request $request)
    {
        $userId = Auth::id();
        $perPage = $request->query('per_page', 10);
        $productName = $request->query('product_name');

        // Query get data transaksi
        $query = SalesTransaction::join('products', 'sales_transactions.product_id', '=', 'products.product_id')
            ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', $userId)
            ->select(
                'sales_transactions.sales_id',
                'products.product_name',
                'sales_transactions.sales_date',
                'sales_transactions.sales_quantity',
                'sales_transactions.price_per_item',
                'sales_transactions.total'
            )
            ->orderBy('sales_transactions.sales_date', 'desc')
            ->orderBy('products.product_name', 'asc');

        // Tambahkan filter berdasarkan nama produk jika ada
        if ($productName) {
            $query->where('products.product_name', 'like', '%' . $productName . '%');
        }

        // Tambahkan filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query->whereBetween('sales_transactions.sales_date', [$startDate, $endDate]);
        }

        // Pagination
        $salesHistory = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $salesHistory->items(),
            'pagination' => [
                'current_page' => $salesHistory->currentPage(),
                'last_page' => $salesHistory->lastPage(),
                'per_page' => $salesHistory->perPage(),
                'total' => $salesHistory->total(),
            ],
        ], 200);
    }
    public function storeManualSales(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'kuantitas' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Produk tidak ada',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'kuantitas.required' => 'Kuantitas tidak boleh kosong',
            'kuantitas.integer' => 'Kuantitas harus berupa angka bulat',
            'kuantitas.min' => 'Kuantitas minimal 1',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0'
        ]);

        $productId = $request->product_id;
        $total = $request->harga * $request->kuantitas;

        $salesTransaction = SalesTransaction::create([
            'product_id' => $productId,
            'sales_date' => $request->tanggal,
            'price_per_item' => $request->harga,
            'sales_quantity' => $request->kuantitas,
            'total' => $total,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan',
            'data' => $salesTransaction,
        ], 201);
    }

    public function inputPenjualanView()
    {
        return view('penjualan.penjualan_input'); // Blade view
    }

    public function inputPenjualanFileView()
    {
        return view('penjualan.input_penjualan_file'); // Blade view
    }

    public function inputPenjualanManualView()
    {
        return view('penjualan.input_penjualan_manual'); // Blade view
    }

    public function riwayatView()
    {
        $user = Auth::user();

        return view('penjualan.penjualan_history', compact('user'));
    }

    public function demandView()
    {
        return view('penjualan.penjualan_prediksi_demand'); // Blade view
    }

    public function profitView()
    {
        return view('penjualan.penjualan_prediksi_profit'); // Blade view
    }
}
