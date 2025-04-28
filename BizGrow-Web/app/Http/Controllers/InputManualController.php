<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputManualController extends Controller
{
    // Menampilkan halaman input penjualan manual
    public function inputPenjualanManualView()
    {
        return view('penjualan.input_penjualan_manual');
    }

    // Menyimpan data penjualan manual tanpa model
    public function storeManualSales(Request $request)
    {
        // Sesuaikan dengan nama field yang dikirim dari Postman
        $request->validate([
            'tanggal' => 'required|date',
            'namaProduk' => 'required|string|max:255', // HARUS sama dengan Postman
            'harga' => 'required|numeric|min:0',
            'kuantitas' => 'required|integer|min:1',
        ]);

        // Simpan ke database
        DB::table('penjualans')->insert([
            'tanggal' => $request->tanggal,
            'nama_produk' => $request->namaProduk, // Sesuai dengan Postman
            'harga' => $request->harga,
            'kuantitas' => $request->kuantitas,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Data penjualan berhasil disimpan!'], 200);
    }
}
