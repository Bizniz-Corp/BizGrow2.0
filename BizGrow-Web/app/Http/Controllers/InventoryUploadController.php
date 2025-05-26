<?php
// app/Http/Controllers/Api/InventoryUploadController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SalesTransaction;
use App\Models\StockChange;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InventoryUploadController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $header = true;
            foreach ($rows as $row) {
                if ($header) {
                    $header = false;
                    continue;
                }

                // Excel structure:
                // 0 = product_id
                // 1 = buffer_stock (stock added)
                // 2 = sales_quantity
                // 3 = price_per_item
                // 4 = sales_date (optional)

                $product_id      = $row[0] ?? null;
                $buffer          = (int) ($row[1] ?? 0);
                $sales_quantity  = (int) ($row[2] ?? 0);
                $price_per_item  = (int) ($row[3] ?? 0);
                $sales_date      = $row[4] ?? now();
                $total           = $sales_quantity * $price_per_item;

                if (!$product_id) continue;

                // Hitung total stok saat ini berdasarkan buffer
                // (misalnya dari riwayat sebelumnya, kamu bisa ambil dari Product jika ada kolom 'stock')
                // Di sini kita buat simple: total_stock = last stock + buffer - sales
                // Asumsi awal: hitung stok dari StockChange sebelumnya
                $lastStockChange = StockChange::where('product_id', $product_id)->latest()->first();
                $previousStock   = $lastStockChange->total_stock ?? 0;
                $newStock        = $previousStock + $buffer - $sales_quantity;

                StockChange::create([
                    'product_id'       => $product_id,
                    'changes_quantity' => $buffer,
                    'changes_date'     => now(),
                    'total_stock'      => $newStock,
                ]);

                SalesTransaction::create([
                    'product_id'      => $product_id,
                    'sales_quantity'  => $sales_quantity,
                    'price_per_item'  => $price_per_item,
                    'total'           => $total,
                    'sales_date'      => $sales_date,
                ]);
            }

            return response()->json([
                'message' => 'Upload berhasil',
                'status'  => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membaca file: ' . $e->getMessage(),
                'status'  => false,
            ], 500);
        }
    }
}
