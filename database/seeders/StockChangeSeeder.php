<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockChange;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk
        $products = Product::all();

        foreach ($products as $product) {
            $currentStock = 0; // Set stok awal untuk setiap produk ke 0 atau bisa disesuaikan
            $lastChangeDate = now()->subDays(rand(365, 365)); // Tanggal acak dalam 1 tahun terakhir

            for ($i = 1; $i <= 15; $i++) {
                // Generate perubahan stok secara acak (bisa negatif atau positif)
                $changeQuantity = rand(-100, 200); // Perubahan stok (-100 hingga +200)

                // Hitung total stok baru, pastikan stok tidak negatif
                $newStock = max(0, $currentStock + $changeQuantity); // Set stok total minimal 0

                // Tambahkan waktu pada tanggal perubahan agar urut (buatnya lebih besar)
                $lastChangeDate = $lastChangeDate->addDays(rand(0, 30)); // Menambah 1 sampai 30 hari pada tanggal sebelumnya

                // Simpan perubahan stok ke tabel stock_changes
                StockChange::create([
                    'product_id' => $product->product_id,
                    'changes_date' => $lastChangeDate, // Tanggal perubahan stok, urut dari perubahan sebelumnya
                    'changes_quantity' => $changeQuantity,
                    'total_stock' => $newStock,
                ]);

                // Update stok saat ini menjadi stok setelah perubahan
                $currentStock = $newStock;
            }
        }
    }
}
