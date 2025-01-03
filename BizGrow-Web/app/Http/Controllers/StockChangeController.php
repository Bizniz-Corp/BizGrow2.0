<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockChange;
use App\Models\Product;

class StockChangeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'product_id' => 'required|exists:products,product_id',
            'kuantitas' => 'required|integer',
        ]);

        StockChange::create([
            'product_id' => $validated['product_id'],
            'changes_date' => $validated['tanggal'],
            'changes_quantity' => $validated['kuantitas'],
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }
}
