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
        $filePath = database_path('data/sales_transactions.csv');
        $excludedProductIds = [];

        // --- LANGKAH 1: Identifikasi produk dari CSV untuk dikecualikan ---
        if (File::exists($filePath)) {
            $data = array_map('str_getcsv', file($filePath));
            $header = array_map('trim', array_shift($data)); // Ambil dan hapus header

            // Dapatkan semua nama produk unik dari file CSV
            $productNamesInCsv = [];
            $productColumnIndex = array_search('product', $header); // Cari indeks kolom 'product'

            if ($productColumnIndex !== false) {
                foreach ($data as $row) {
                    // Pastikan baris dan kolom ada untuk menghindari error
                    if (isset($row[$productColumnIndex])) {
                        $productNamesInCsv[] = $row[$productColumnIndex];
                    }
                }
            }
            
            // Jika ada nama produk di CSV, cari ID mereka di database
            if (!empty($productNamesInCsv)) {
                $uniqueProductNames = array_unique($productNamesInCsv);
                $excludedProductIds = Product::whereIn('product_name', $uniqueProductNames)
                                             ->pluck('product_id')
                                             ->toArray();
            }
        }

        // --- LANGKAH 2: Generate transaksi random untuk produk yang TIDAK ada di CSV ---

        // Ambil semua produk yang ID-nya TIDAK ADA dalam daftar pengecualian ($excludedProductIds)
        $productsForRandomSeeding = Product::whereNotIn('product_id', $excludedProductIds)->get();

        $this->command->info(count($productsForRandomSeeding) . ' produk akan dibuatkan transaksi random.');

        foreach ($productsForRandomSeeding as $product) {
            $numTransactions = 15; // Minimal 15 transaksi untuk setiap produk

            for ($i = 0; $i < $numTransactions; $i++) {
                $randomDate = Carbon::now()->subDays(rand(1, 450));
                $salesQuantity = rand(1, 40);
                $pricePerItem = $product->price;
                $total = $salesQuantity * $pricePerItem;

                SalesTransaction::create([
                    'product_id' => $product->product_id,
                    'sales_date' => $randomDate,
                    'sales_quantity' => $salesQuantity,
                    'price_per_item' => $pricePerItem,
                    'total' => $total,
                ]);
            }
        }
        
        // --- LANGKAH 3: Impor data transaksi dari file CSV ---

        if (!File::exists($filePath)) {
            $this->command->warn("File CSV tidak ditemukan, proses impor dilewati.");
            return;
        }

        // Membaca ulang file untuk proses impor (agar struktur kode tetap jelas)
        $data = array_map('str_getcsv', file($filePath));
        $header = array_map('trim', $data[0]); // Ambil header CSV
        unset($data[0]); // Hapus header dari data

        $this->command->info('Memulai impor transaksi dari file sales_transactions.csv...');

        foreach ($data as $row) {
            // Pastikan jumlah kolom di baris cocok dengan jumlah header
            if (count($header) !== count($row)) {
                continue;
            }
            $rowData = array_combine($header, $row);

            // Cari product_id berdasarkan nama produk
            // Menggunakan array yang sudah kita buat sebelumnya untuk efisiensi jika diperlukan,
            // tapi query langsung juga tidak masalah.
            $product = Product::where('product_name', $rowData['product'])->first();

            if (!$product) {
                $this->command->error("Produk tidak ditemukan di database: " . $rowData['product']);
                continue; // Skip jika produk tidak ditemukan
            }

            // Insert ke database
            DB::table('sales_transactions')->insert([
                'sales_date' => Carbon::parse($rowData['sales_date'])->toDateTimeString(), // Pastikan format tanggal benar
                'product_id' => $product->product_id,
                'sales_quantity' => (int)$rowData['sales_quantity'],
                'price_per_item' => (int)$rowData['price_per_item'],
                'total' => (int)$rowData['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Impor transaksi dari CSV selesai.');
    }
}