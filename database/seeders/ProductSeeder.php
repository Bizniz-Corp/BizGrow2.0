<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Umkaem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List nama produk asli untuk digunakan secara acak
        $productNames = [
            'Keripik Pisang',
            'Minuman Herbal',
            'Bolu Kukus Pelangi',
            'Sambal Goreng Kentang',
            'Kerupuk Udang',
            'Coklat Premium',
            'Madu Murni',
            'Kopi Arabika',
            'Abon Sapi',
            'Dodol Durian',
            'Keripik Singkong',
            'Kue Lapis',
            'Sate Ayam Madura',
            'Keripik Tempe',
            'Keripik Jamur',
            'Nasi Ayam Geprek',
            'Ubi Jalar Goreng',
            'Kue Putu',
            'Kue Lumpur',
            'Nasi Padang',
            'Sirup Markisa',
            'Rempeyek Kacang',
            'Tape Singkong'
        ];

        // Ambil semua data UMKM
        $umkmList = Umkaem::all();

        foreach ($umkmList as $umkm) {
            // Pilih nama produk secara acak tanpa duplikasi
            $availableProducts = $productNames; // Salin semua nama produk
            $numberOfProducts = rand(5, 8); // Setiap UMKM memiliki 5 hingga 8 produk

            for ($i = 0; $i < $numberOfProducts; $i++) {
                // Ambil produk acak dari list
                $randomIndex = array_rand($availableProducts);
                $productName = $availableProducts[$randomIndex];

                // Buat produk baru
                Product::create([
                    'product_name' => $productName,
                    'product_quantity' => rand(50, 500), // Kuantitas acak
                    'price' => rand(5000, 50000), // Harga acak
                    'umkm_id' => $umkm->umkm_id, // Assign ke UMKM terkait// Stok acak
                ]);

                // Hapus produk dari daftar untuk mencegah duplikasi
                unset($availableProducts[$randomIndex]);
            }
        }

        $products = [
            ['product_name' => 'Margherita Pizza', 'product_quantity' => 1, 'price' => 20000, 'umkm_id' => 5],
            ['product_name' => 'Caprese Salad', 'product_quantity' => 1, 'price' => 16000, 'umkm_id' => 5],
            ['product_name' => 'Tiramisu', 'product_quantity' => 1, 'price' => 13000, 'umkm_id' => 5],
            ['product_name' => 'Gelato', 'product_quantity' => 1, 'price' => 9000, 'umkm_id' => 5],
            ['product_name' => 'Spaghetti Carbonara', 'product_quantity' => 1, 'price' => 24000, 'umkm_id' => 5],
            ['product_name' => 'Fettuccine Alfredo', 'product_quantity' => 1, 'price' => 26000, 'umkm_id' => 5],
            ['product_name' => 'Panna Cotta', 'product_quantity' => 1, 'price' => 11000, 'umkm_id' => 5],
            ['product_name' => 'Minestrone Soup', 'product_quantity' => 1, 'price' => 14000, 'umkm_id' => 5],
            ['product_name' => 'Lasagna', 'product_quantity' => 1, 'price' => 23000, 'umkm_id' => 5],
            ['product_name' => 'Bruschetta', 'product_quantity' => 1, 'price' => 10000, 'umkm_id' => 5],
        ];

        DB::table('products')->insert($products);
    }
}
