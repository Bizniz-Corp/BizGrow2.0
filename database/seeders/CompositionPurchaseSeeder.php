<?php

namespace Database\Seeders;

use App\Models\Composition;
use Illuminate\Database\Seeder;
use App\Models\CompositionPurchaseTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompositionPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua komposisi
        $compositions = Composition::all();

        foreach ($compositions as $composition) {
            // Buat minimal 3 transaksi pembelian untuk setiap komposisi
            $transactionCount = rand(3, 5);

            for ($i = 0; $i < $transactionCount; $i++) {
                $purchaseDate = now()->subDays(rand(1, 365)); // Tanggal acak dalam 1 tahun terakhir

                // Harga per item tetap untuk satu composition_id
                $pricePerItem = rand(1000, 20000);

                // Kuantitas acak
                $quantity = rand(10, 100);

                // Total harga dihitung
                $totalPrice = $pricePerItem * $quantity;

                // Tambahkan data ke tabel
                CompositionPurchaseTransaction::create([
                    'composition_id' => $composition->composition_id,
                    'composition_purchase_date' => $purchaseDate,
                    'composition_purchase_quantity' => $quantity,
                    'composition_price_per_item' => $pricePerItem,
                    'total' => $totalPrice,
                ]);
            }
        }
    }
}
