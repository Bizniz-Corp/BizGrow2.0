<?php

namespace Database\Seeders;

use App\Models\Umkaem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Umkaem::create([
            'user_id' => 6,
            'umkm_name' => 'UMKM A',
        ]);
        Umkaem::create([
            'user_id' => 2,
            'umkm_name' => 'UMKM B',
        ]);

        Umkaem::create([
            'user_id' => 3,
            'umkm_name' => 'UMKM C',
        ]);

        Umkaem::create([
            'user_id' => 4,
            'umkm_name' => 'UMKM D',
        ]);

        Umkaem::create([
            'user_id' => 5,
            'umkm_name' => 'UMKM E',
        ]);
    }
}
