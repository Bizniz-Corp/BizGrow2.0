<?php

namespace Database\Seeders;

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
        Composition::create([
            'composition_name' => 'Composition A',
            'composition_quantity' => 100,
            'current_composition_price' => 5000,
            'product_id' => 1,
        ]);

        Composition::create([
            'composition_name' => 'Composition B',
            'composition_quantity' => 50,
            'current_composition_price' => 8000,
            'product_id' => 2,
        ]);

        Composition::create([
            'composition_name' => 'Composition C',
            'composition_quantity' => 75,
            'current_composition_price' => 6000,
            'product_id' => 3,
        ]);

        Composition::create([
            'composition_name' => 'Composition D',
            'composition_quantity' => 120,
            'current_composition_price' => 4500,
            'product_id' => 4,
        ]);

        Composition::create([
            'composition_name' => 'Composition E',
            'composition_quantity' => 85,
            'current_composition_price' => 5500,
            'product_id' => 5,
        ]);
    }
}
