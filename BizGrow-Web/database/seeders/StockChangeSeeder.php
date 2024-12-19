<?php

namespace Database\Seeders;

use App\Models\StockChange;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockChange::create([
            'product_id' => 1,
            'changes_date' => now(),
            'changes_quantity' => 15,
        ]);

        StockChange::create([
            'product_id' => 2,
            'changes_date' => now(),
            'changes_quantity' => -5,
        ]);

        StockChange::create([
            'product_id' => 3,
            'changes_date' => now(),
            'changes_quantity' => 10,
        ]);

        StockChange::create([
            'product_id' => 4,
            'changes_date' => now(),
            'changes_quantity' => -3,
        ]);

        StockChange::create([
            'product_id' => 5,
            'changes_date' => now(),
            'changes_quantity' => 8,
        ]);
    }
}
