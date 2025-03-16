<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\SalesTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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


        // Untuk Model
        $filePath = database_path('data/sales_transactions.csv');

        if (!File::exists($filePath)) {
            // $this->command->error("File not found: $filePath");
            return;
        }

        $data = array_map('str_getcsv', file($filePath));
        $header = array_map('trim', $data[0]); // Ambil header CSV
        unset($data[0]); // Hapus header dari data

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            // Cari product_id berdasarkan nama produk
            $productId = DB::table('products')
                ->where('product_name', $rowData['product'])
                ->value('product_id');

            if (!$productId) {
                // $this->command->error("Product not found: " . $rowData['product']);
                continue; // Skip jika produk tidak ditemukan
            }

            // Insert ke database
            DB::table('sales_transactions')->insert([
                'sales_date' => $rowData['sales_date'], // Pastikan format sudah sesuai
                'product_id' => $productId,
                'sales_quantity' => (int)$rowData['sales_quantity'],
                'price_per_item' => (int)$rowData['price_per_item'],
                'total' => (int)$rowData['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
