<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Umkaem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dengan role 'umkm'
        $umkmUsers = User::where('role', 'umkm')->get();

        foreach ($umkmUsers as $user) {
            Umkaem::create([
                'user_id' => $user->id,
                'npwp_no' => $this->generateNpwp(),
                'izin_usaha_path' => 'uploads/surat_izin/' . strtolower(str_replace(' ', '_', $user->name)) . '_npwp.pdf',
            ]);
        }
    }
    /**
     * Generate a random NPWP number in the correct format.
     *
     * @return string
     */
    private function generateNpwp()
    {
        return sprintf(
            '%02d.%03d.%03d.%01d-%03d.%03d',
            rand(1, 99), // First two digits
            rand(1, 999), // Group 1
            rand(1, 999), // Group 2
            rand(1, 9), // Main Identifier
            rand(1, 999), // Branch Code
            rand(1, 999) // Regional Code
        );
    }
}
