<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\SalesTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk yang tersedia
        $products = Product::all();

        foreach ($products as $product) {
            // Minimal 15 transaksi untuk setiap produk
            $numTransactions = 15;

            for ($i = 0; $i < $numTransactions; $i++) {
                // Tentukan tanggal acak dalam rentang 60 hari terakhir
                $randomDate = Carbon::now()->subDays(rand(1, 450)); // Menghasilkan tanggal acak dalam 60 hari terakhir

                // Tentukan jumlah yang dijual dan harga totalnya
                $salesQuantity = rand(1, 40); // Kuantitas transaksi acak
                $pricePerItem = $product->price; // Harga produk yang konsisten

                // Hitung total transaksi
                $total = $salesQuantity * $pricePerItem;

                // Buat transaksi penjualan baru
                SalesTransaction::create([
                    'product_id' => $product->product_id,
                    'sales_date' => $randomDate, // Menggunakan tanggal acak
                    'sales_quantity' => $salesQuantity,
                    'price_per_item' => $pricePerItem,
                    'total' => $total,
                ]);
            }
        }
    }
}
