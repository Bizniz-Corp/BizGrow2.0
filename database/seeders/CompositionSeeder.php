<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Composition;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar komposisi makanan
        $ingredients = [
            'Keju',
            'Gula',
            'Air Putih',
            'Susu Bubuk',
            'Telur',
            'Tepung Terigu',
            'Cokelat',
            'Kacang Almond',
            'Pewarna Makanan',
            'Pasta Vanila',
            'Garam',
            'Minyak Goreng',
            'Madu',
            'Baking Powder',
            'Ragi'
        ];

        // Ambil semua produk
        $products = Product::all();

        foreach ($products as $product) {
            // Tentukan apakah produk memiliki komposisi atau tidak (50% peluang)
            if (rand(0, 1) === 1) {
                // Buat jumlah komposisi antara 1 hingga 5 untuk produk tersebut
                $compositionCount = rand(1, 5);

                for ($i = 0; $i < $compositionCount; $i++) {
                    // Pilih nama bahan secara acak
                    $randomIngredient = $ingredients[array_rand($ingredients)];

                    Composition::create([
                        'composition_name' => $randomIngredient,
                        'composition_quantity' => rand(10, 200), // Kuantitas komposisi antara 10 dan 200
                        'current_composition_price' => rand(1000, 20000), // Harga antara 1000 dan 20000
                        'product_id' => $product->product_id,
                    ]);
                }
            }
        }
    }
}
