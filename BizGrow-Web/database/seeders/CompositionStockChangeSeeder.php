<?php

namespace Database\Seeders;

use App\Models\CompositionStockChange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompositionStockChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompositionStockChange::create([
            'composition_id' => 1,
            'composition_changes_date' => now(),
            'composition_changes_quantity' => 20,
        ]);

        CompositionStockChange::create([
            'composition_id' => 2,
            'composition_changes_date' => now(),
            'composition_changes_quantity' => -5,
        ]);

        CompositionStockChange::create([
            'composition_id' => 3,
            'composition_changes_date' => now(),
            'composition_changes_quantity' => 15,
        ]);

        CompositionStockChange::create([
            'composition_id' => 4,
            'composition_changes_date' => now(),
            'composition_changes_quantity' => -3,
        ]);

        CompositionStockChange::create([
            'composition_id' => 5,
            'composition_changes_date' => now(),
            'composition_changes_quantity' => 10,
        ]);
    }
}
