<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function getSalesHistory()
    {
        $userId = Auth::id();

        $salesHistory = SalesTransaction::join('products', 'sales_transactions.product_id', '=', 'products.product_id')
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
            ->orderBy('products.product_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $salesHistory,
        ], 200);

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
        return view('penjualan.penjualan_history'); // Blade view
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
