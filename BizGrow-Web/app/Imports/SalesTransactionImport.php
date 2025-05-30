<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesTransactionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $requiredHeaders = [
            'produk',
            'tanggal_penjualan',
            'harga_satuan',
            'jumlah_barang',
            'total_harga'
        ];

        foreach ($requiredHeaders as $header) {
            if (!array_key_exists($header, $row)) {
                // Bisa throw error atau log saja
                throw ValidationException::withMessages([
                    'excel' => "Header kolom '$header' tidak ditemukan. Harap periksa file Excel."
                ]);
            }
        }

        // Cek apakah produk sudah ada
        $product = Product::whereRaw('LOWER(product_name) = ?', [strtolower($row['produk'])])->first();

        // Jika tidak ada, tambahkan produk baru
        if (!$product) {
            $userId = Auth::id();
            $umkmId = DB::table('umkms')->where('user_id', $userId)->value('umkm_id');
            $product = Product::create([
                'umkm_id' => $umkmId,
                'product_name' => $row['produk'],
                'price' => $row['harga_satuan'],
                'product_quantity' => 0,
            ]);
        }

        return new SalesTransaction([
            'product_id' => $product->product_id,
            'sales_date' => $row['tanggal_penjualan'],
            'price_per_item' => $row['harga_satuan'],
            'sales_quantity' => $row['jumlah_barang'],
            'total' => $row['total_harga'],
        ]);
    }
}
