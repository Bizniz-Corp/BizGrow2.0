<?php

namespace Database\Seeders;

use App\Models\SalesTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalesTransaction::create([
            'product_id' => 1,
            'sales_date' => now(),
            'sales_quantity' => 10,
            'price_per_item' => 50000,
            'total' => 500000,
        ]);

        SalesTransaction::create([
            'product_id' => 2,
            'sales_date' => now(),
            'sales_quantity' => 5,
            'price_per_item' => 30000,
            'total' => 150000,
        ]);

        SalesTransaction::create([
            'product_id' => 3,
            'sales_date' => now(),
            'sales_quantity' => 3,
            'price_per_item' => 20000,
            'total' => 60000,
        ]);

        SalesTransaction::create([
            'product_id' => 4,
            'sales_date' => now(),
            'sales_quantity' => 8,
            'price_per_item' => 70000,
            'total' => 560000,
        ]);

        SalesTransaction::create([
            'product_id' => 5,
            'sales_date' => now(),
            'sales_quantity' => 7,
            'price_per_item' => 45000,
            'total' => 315000,
        ]);
    }
}
