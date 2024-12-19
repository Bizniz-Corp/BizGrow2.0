<?php

namespace Database\Seeders;

use App\Models\PurchaseTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseTransaction::create([
            'product_id' => 1,
            'purchase_date' => now(),
            'purchase_quantity' => 30,
            'price_per_item' => 48000,
            'total' => 1440000,
        ]);

        PurchaseTransaction::create([
            'product_id' => 2,
            'purchase_date' => now(),
            'purchase_quantity' => 20,
            'price_per_item' => 27000,
            'total' => 540000,
        ]);

        PurchaseTransaction::create([
            'product_id' => 3,
            'purchase_date' => now(),
            'purchase_quantity' => 25,
            'price_per_item' => 19000,
            'total' => 475000,
        ]);

        PurchaseTransaction::create([
            'product_id' => 4,
            'purchase_date' => now(),
            'purchase_quantity' => 40,
            'price_per_item' => 66000,
            'total' => 2640000,
        ]);

        PurchaseTransaction::create([
            'product_id' => 5,
            'purchase_date' => now(),
            'purchase_quantity' => 35,
            'price_per_item' => 43000,
            'total' => 1505000,
        ]);
    }
}
