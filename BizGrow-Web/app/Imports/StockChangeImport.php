<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockChange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockChangeImport implements ToModel, WithHeadingRow
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
            'jumlah_perubahan',
            'tanggal_perubahan'
        ];
        foreach ($requiredHeaders as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'excel' => "Header kolom '$header' tidak ditemukan. Harap periksa file Excel."
                ]);
            }
        }

        // Cari produk, buat jika belum ada
        $product = Product::whereRaw('LOWER(product_name) = ?', [strtolower($row['produk'])])->first();
        if (!$product) {
            $userId = Auth::id();
            $umkmId = DB::table('umkms')->where('user_id', $userId)->value('umkm_id');
            $product = Product::create([
                'umkm_id' => $umkmId,
                'product_name' => $row['produk'],
                'product_quantity' => 0,
                'price' => 0
            ]);
        }
        $totalStock = StockChange::where('product_id', $product->product_id)->sum('changes_quantity') + $row['jumlah_perubahan'];
        if ($totalStock < 0) {
            $totalStock = 0; // Pastikan stok tidak negatif
        }

        return new StockChange([
            'product_id' => $product->product_id,
            'changes_quantity' => $row['jumlah_perubahan'],
            'changes_date' => $row['tanggal_perubahan'],
            'total_stock' => $totalStock
        ]);
    }
}
