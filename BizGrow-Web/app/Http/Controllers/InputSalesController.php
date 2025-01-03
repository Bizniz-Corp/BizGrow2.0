<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesTransaction;

class InputSalesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'product_id' => 'required|exists:products,product_id',
            'harga' => 'required|numeric|min:1',
            'kuantitas' => 'required|numeric|min:1',
        ]);

        $total = $validated['harga'] * $validated['kuantitas'];

        SalesTransaction::create([
            'sales_date' => $validated['tanggal'],
            'product_id' => $validated['product_id'],
            'sales_quantity' => $validated['kuantitas'],
            'price_per_item' => $validated['harga'],
            'total' => $total,
        ]);

        return redirect()->back()->with('success', 'Data successfully saved!');
    }
}
