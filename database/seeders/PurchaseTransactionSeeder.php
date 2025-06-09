<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchaseTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk yang tersedia
        $products = Product::all();

        foreach ($products as $product) {
            // Minimal 15 transaksi pembelian untuk setiap produk
            $numTransactions = 15;

            for ($i = 0; $i < $numTransactions; $i++) {
                // Tentukan tanggal acak dalam rentang 60 hari terakhir
                $randomDate = Carbon::now()->subDays(rand(1, 450)); // Menghasilkan tanggal acak dalam 60 hari terakhir

                // Tentukan jumlah yang dibeli dan harga pembeliannya
                $purchaseQuantity = rand(1, 100); // Kuantitas transaksi acak untuk pembelian
                $pricePerItem = $product->price - rand(1000, 5000); // Harga produk yang sedikit lebih murah sebagai harga beli

                // Hitung total transaksi
                $total = $purchaseQuantity * $pricePerItem;

                // Buat transaksi pembelian baru
                PurchaseTransaction::create([
                    'product_id' => $product->product_id,
                    'purchase_date' => $randomDate, // Menggunakan tanggal acak
                    'purchase_quantity' => $purchaseQuantity,
                    'price_per_item' => $pricePerItem,
                    'total' => $total,
                ]);
            }
        }
    }
}
