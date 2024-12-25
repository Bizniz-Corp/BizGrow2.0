<?php

namespace Database\Seeders;

use App\Models\Composition;
use Illuminate\Database\Seeder;
use App\Models\CompositionStockChange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompositionStockChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua data komposisi
        $compositions = Composition::all();

        foreach ($compositions as $composition) {
            $currentStock = 0; // Inisialisasi total stok

            // Buat 3 perubahan stok untuk setiap komposisi
            for ($i = 0; $i < 3; $i++) {
                $changesDate = now()->subDays(rand(1, 365)); // Tanggal acak dalam 1 tahun terakhir

                // Jumlah perubahan bisa positif atau negatif
                $changesQuantity = rand(-100, 100);

                // Update total stok berdasarkan perubahan
                $currentStock += $changesQuantity;

                // Total stok tidak boleh negatif
                if ($currentStock < 0) {
                    $currentStock = 0;
                }

                // Tambahkan data ke tabel
                CompositionStockChange::create([
                    'composition_id' => $composition->composition_id,
                    'composition_changes_date' => $changesDate,
                    'composition_changes_quantity' => $changesQuantity,
                    'total_composition_stock' => $currentStock,
                ]);
            }
        }
    }
}
