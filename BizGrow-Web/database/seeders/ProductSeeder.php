<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Product::create([
            'product_name' => 'Product A',
            'product_quantity' => 100,
            'price' => 50000,
            'umkm_id' => 1,
        ]);

        Product::create([
            'product_name' => 'Product B',
            'product_quantity' => 50,
            'price' => 30000,
            'umkm_id' => 2,
        ]);

        Product::create([
            'product_name' => 'Product C',
            'product_quantity' => 30,
            'price' => 20000,
            'umkm_id' => 3,
        ]);

        Product::create([
            'product_name' => 'Product D',
            'product_quantity' => 120,
            'price' => 70000,
            'umkm_id' => 4,
        ]);

        Product::create([
            'product_name' => 'Product E',
            'product_quantity' => 80,
            'price' => 45000,
            'umkm_id' => 5,
        ]);
    }
}
