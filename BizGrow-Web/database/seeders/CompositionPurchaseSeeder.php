<?php

namespace Database\Seeders;

use App\Models\CompositionPurchaseTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompositionPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompositionPurchaseTransaction::create([
            'composition_id' => 1,
            'composition_purchase_date' => now(),
            'composition_purchase_quantity' => 10,
            'composition_price_per_item' => 5000,
            'total' => 50000,
        ]);

        CompositionPurchaseTransaction::create([
            'composition_id' => 2,
            'composition_purchase_date' => now(),
            'composition_purchase_quantity' => 15,
            'composition_price_per_item' => 8000,
            'total' => 120000,
        ]);

        CompositionPurchaseTransaction::create([
            'composition_id' => 3,
            'composition_purchase_date' => now(),
            'composition_purchase_quantity' => 12,
            'composition_price_per_item' => 6000,
            'total' => 72000,
        ]);

        CompositionPurchaseTransaction::create([
            'composition_id' => 4,
            'composition_purchase_date' => now(),
            'composition_purchase_quantity' => 8,
            'composition_price_per_item' => 4500,
            'total' => 36000,
        ]);

        CompositionPurchaseTransaction::create([
            'composition_id' => 5,
            'composition_purchase_date' => now(),
            'composition_purchase_quantity' => 25,
            'composition_price_per_item' => 5500,
            'total' => 137500,
        ]);
    }
}
