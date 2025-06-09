<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Umkaem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List nama produk asli untuk digunakan secara acak
        $productNames = [
            'Keripik Pisang',
            'Minuman Herbal',
            'Bolu Kukus Pelangi',
            'Sambal Goreng Kentang',
            'Kerupuk Udang',
            'Coklat Premium',
            'Madu Murni',
            'Kopi Arabika',
            'Abon Sapi',
            'Dodol Durian',
            'Keripik Singkong',
            'Kue Lapis',
            'Sate Ayam Madura',
            'Keripik Tempe',
            'Keripik Jamur',
            'Nasi Ayam Geprek',
            'Ubi Jalar Goreng',
            'Kue Putu',
            'Kue Lumpur',
            'Nasi Padang',
            'Sirup Markisa',
            'Rempeyek Kacang',
            'Tape Singkong'
        ];

        // Ambil semua data UMKM
        $umkmList = Umkaem::all();
        $umkmListExceptLast = $umkmList->slice(0, $umkmList->count() - 1);

        foreach ($umkmListExceptLast as $umkm) {
            // Pilih nama produk secara acak tanpa duplikasi
            $availableProducts = $productNames; // Salin semua nama produk
            $numberOfProducts = rand(5, 8); // Setiap UMKM memiliki 5 hingga 8 produk

            for ($i = 0; $i < $numberOfProducts; $i++) {
                // Ambil produk acak dari list
                $randomIndex = array_rand($availableProducts);
                $productName = $availableProducts[$randomIndex];

                // Buat produk baru
                Product::create([
                    'product_name' => $productName,
                    'product_quantity' => rand(50, 500), // Kuantitas acak
                    'price' => rand(5000, 50000), // Harga acak
                    'umkm_id' => $umkm->umkm_id, // Assign ke UMKM terkait// Stok acak
                ]);

                // Hapus produk dari daftar untuk mencegah duplikasi
                unset($availableProducts[$randomIndex]);
            }
        }

        // $products = [
        //     ['product_name' => 'Margherita Pizza', 'product_quantity' => 1, 'price' => 20000, 'umkm_id' => 8],
        //     ['product_name' => 'Caprese Salad', 'product_quantity' => 1, 'price' => 16000, 'umkm_id' => 8],
        //     ['product_name' => 'Tiramisu', 'product_quantity' => 1, 'price' => 13000, 'umkm_id' => 8],
        //     ['product_name' => 'Gelato', 'product_quantity' => 1, 'price' => 9000, 'umkm_id' => 8],
        //     ['product_name' => 'Spaghetti Carbonara', 'product_quantity' => 1, 'price' => 24000, 'umkm_id' => 8],
        //     ['product_name' => 'Fettuccine Alfredo', 'product_quantity' => 1, 'price' => 26000, 'umkm_id' => 8],
        //     ['product_name' => 'Panna Cotta', 'product_quantity' => 1, 'price' => 11000, 'umkm_id' => 8],
        //     ['product_name' => 'Minestrone Soup', 'product_quantity' => 1, 'price' => 14000, 'umkm_id' => 8],
        //     ['product_name' => 'Lasagna', 'product_quantity' => 1, 'price' => 23000, 'umkm_id' => 8],
        //     ['product_name' => 'Bruschetta', 'product_quantity' => 1, 'price' => 10000, 'umkm_id' => 8],
        // ];

        // DB::table('products')->insert($products);

        $this->command->info('Starting to seed products from CSV file...');

        try {
            // 1. Find the UMKM ID from the 'users' table based on email
            $user = User::where('email', 'reza@gmail.com')->firstOrFail();
            $umkmId = $user->id;

            // 2. Define the path to the CSV file
            $filePath = database_path('data/data_penjualan_ayamskb.csv');

            if (!file_exists($filePath)) {
                throw new Exception("CSV file not found at: " . $filePath);
            }

            // 3. Read and process the CSV data
            $processedProducts = [];
            $file = fopen($filePath, 'r');
            
            // Read the header to dynamically find column indexes
            $header = fgetcsv($file);
            $productIndex = array_search('product', $header);
            $quantityIndex = array_search('sales_quantity', $header);
            $priceIndex = array_search('price_per_item', $header);
            $dateIndex = array_search('sales_date', $header);

            // Validate that all required columns are present
            if ($productIndex === false || $quantityIndex === false || $priceIndex === false || $dateIndex === false) {
                throw new Exception('CSV is missing one of the required columns: product, sales_quantity, price_per_item, sales_date');
            }

            while (($row = fgetcsv($file)) !== false) {
                $productName = $row[$productIndex];
                $quantity = (int)$row[$quantityIndex];
                $price = (float)$row[$priceIndex];
                $date = $row[$dateIndex];

                if (!isset($processedProducts[$productName])) {
                    // If this is the first time we see this product, initialize it
                    $processedProducts[$productName] = [
                        'total_quantity' => $quantity,
                        'latest_date' => $date,
                        'price' => $price,
                    ];
                } else {
                    // If product already exists, sum the quantity
                    $processedProducts[$productName]['total_quantity'] += $quantity;

                    // Check if the current row's date is newer. If so, update the price.
                    if (strtotime($date) > strtotime($processedProducts[$productName]['latest_date'])) {
                        $processedProducts[$productName]['latest_date'] = $date;
                        $processedProducts[$productName]['price'] = $price;
                    }
                }
            }
            fclose($file);

            // 4. Insert the processed products into the database
            if (empty($processedProducts)) {
                 $this->command->warn('No products were processed from the CSV file.');
                 return;
            }
            
            $this->command->info("Found " . count($processedProducts) . " unique products. Inserting into database...");

            foreach ($processedProducts as $name => $data) {
                Product::create([
                    'product_name' => $name,
                    'product_quantity' => $data['total_quantity'],
                    'price' => $data['price'],
                    'umkm_id' => $umkmId,
                ]);

                // 5. Display the message in the console
                $this->command->info("  -> Added: {$name} | Price: {$data['price']} | UMKM ID: {$umkmId}");
            }
            
            $this->command->info('Successfully seeded products from CSV.');

        } catch (Exception $e) {
            // Display any errors that occur during the process
            $this->command->error('An error occurred during CSV seeding: ' . $e->getMessage());
        }
    }
}
