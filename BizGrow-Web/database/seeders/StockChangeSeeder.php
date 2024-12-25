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
            $currentStock = 0; // Awal total stok setiap produk

            for ($i = 1; $i <= 15; $i++) {
                // Random perubahan stok (bisa positif atau negatif)
                $changeQuantity = rand(-200, 300);

                // Hitung total stok baru (jangan sampai stok negatif)
                $newStock = max(0, $currentStock + $changeQuantity);

                // Tambahkan ke tabel stock_changes
                StockChange::create([
                    'product_id' => $product->product_id,
                    'changes_date' => now()->subDays(rand(1, 365))->addMinutes(rand(1, 1440)),
                    'changes_quantity' => $changeQuantity,
                    'total_stock' => $newStock,
                ]);

                // Update stok saat ini
                $currentStock = $newStock;
            }
        }
    }
}
