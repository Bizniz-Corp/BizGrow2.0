<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SalesTransactionImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SalesController extends Controller
{
    protected $fastApiPredictUrl;

    public function __construct()
    {
        $baseUrl = rtrim(env('FASTAPI_PREDICTION_URL'), '/');
        if (strpos($baseUrl, '/predict') === false) {
             $this->fastApiPredictUrl = env('FASTAPI_PREDICTION_URL');
        } else {
            $this->fastApiPredictUrl = $baseUrl;
        }
    }

    public function getSalesHistory(Request $request)
    {
        $userId = Auth::id();
        $perPage = $request->query('per_page', 10);
        $productName = $request->query('product_name');

        // Query get data transaksi
        $query = SalesTransaction::join('products', 'sales_transactions.product_id', '=', 'products.product_id')
            ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', $userId)
            ->select(
                'sales_transactions.sales_id',
                'products.product_name',
                'sales_transactions.sales_date',
                'sales_transactions.sales_quantity',
                'sales_transactions.price_per_item',
                'sales_transactions.total'
            )
            ->orderBy('sales_transactions.sales_date', 'desc')
            ->orderBy('products.product_name', 'asc');

        // Tambahkan filter berdasarkan nama produk jika ada
        if ($productName) {
            $query->where('products.product_name', 'like', '%' . $productName . '%');
        }

        // Tambahkan filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query->whereBetween('sales_transactions.sales_date', [$startDate, $endDate]);
        }

        // Pagination
        $salesHistory = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $salesHistory->items(),
            'pagination' => [
                'current_page' => $salesHistory->currentPage(),
                'last_page' => $salesHistory->lastPage(),
                'per_page' => $salesHistory->perPage(),
                'total' => $salesHistory->total(),
            ],
        ], 200);
    }
    public function storeManualSales(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'kuantitas' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Produk tidak ada',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'kuantitas.required' => 'Kuantitas tidak boleh kosong',
            'kuantitas.integer' => 'Kuantitas harus berupa angka bulat',
            'kuantitas.min' => 'Kuantitas minimal 1',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0'
        ]);

        $productId = $request->product_id;
        $total = $request->harga * $request->kuantitas;

        $salesTransaction = SalesTransaction::create([
            'product_id' => $productId,
            'sales_date' => $request->tanggal,
            'price_per_item' => $request->harga,
            'sales_quantity' => $request->kuantitas,
            'total' => $total,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan',
            'data' => $salesTransaction,
        ], 201);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'inputFileSale' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new SalesTransactionImport, $request->file('inputFileSale'));

        return response()->json([
            'message' => 'Data penjualan berhasil diimpor',
        ], 200);
    }

    public function exportPdf()
    {
        $sales = SalesTransaction::join('products', 'sales_transactions.product_id', '=', 'products.product_id')
            ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', Auth::id())
            ->select(
                'sales_transactions.sales_id',
                'products.product_name',
                'sales_transactions.sales_date',
                'sales_transactions.sales_quantity',
                'sales_transactions.price_per_item',
                'sales_transactions.total'
            )
            ->orderBy('sales_transactions.sales_date', 'desc')
            ->orderBy('products.product_name', 'asc')
            ->get();

        $pdf = Pdf::loadView('penjualan.penjualan_history_pdf', compact('sales'));
        return $pdf->download('riwayat_penjualan.pdf');
    }

    public function inputPenjualanView()
    {
        return view('penjualan.penjualan_input'); // Blade view
    }

    public function inputPenjualanFileView()
    {
        return view('penjualan.input_penjualan_file'); // Blade view
    }

    public function inputPenjualanManualView()
    {
        return view('penjualan.input_penjualan_manual'); // Blade view
    }

    public function riwayatView()
    {
        $user = Auth::user();

        return view('penjualan.penjualan_history', compact('user'));
    }

    public function prediksiDemandView()
    {
        $user = Auth::user();
        $products = DB::table('products')
                        ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
                        ->where('umkms.user_id', Auth::id())
                        ->orderBy('products.product_name', 'asc')
                        ->pluck('products.product_name')->unique()->values();

        return view('penjualan.penjualan_prediksi_demand', compact('user', 'products'));
    }

    public function getDailyProductDemandSummary(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) { /* ... error handling ... */ }

        try {
            $query = DB::table('sales_transactions')
                ->join('products', 'sales_transactions.product_id', '=', 'products.product_id')
                ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
                ->where('umkms.user_id', $userId)
                ->select(
                    DB::raw('DATE(sales_transactions.sales_date) as date'),
                    'products.product_name', // Penting
                    DB::raw('SUM(sales_transactions.sales_quantity) as total_quantity')
                )
                ->groupBy('date', 'products.product_name')
                ->orderBy('date', 'asc')
                ->orderBy('products.product_name', 'asc');

            $dailyDemand = $query->get()->map(function ($item) {
                $item->date = Carbon::parse($item->date)->toDateString();
                $item->type = 'historical_db'; // Untuk JS membedakan
                // Kolom 'product_name' sudah ada
                // Kolom 'total_quantity' sudah ada, ini akan menjadi nilai Y untuk produk tersebut
                return $item;
            });

            return response()->json(['success' => true, 'data' => $dailyDemand]);

        } catch (\Exception $e) { /* ... error handling ... */ }
    }

    public function getDemandPredictions(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        if (empty($this->fastApiPredictUrl)) {
            Log::error('FASTAPI_PROFIT_PREDICT_URL is not set in .env file.');
            return response()->json(['success' => false, 'message' => 'FastAPI URL is not configured.'], 500);
        }

        try {
            $historicalDataForModel = DB::table('sales_transactions')
                ->join('products', 'sales_transactions.product_id', '=', 'products.product_id')
                ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
                ->where('umkms.user_id', $userId)
                ->select(
                    'sales_transactions.sales_date',
                    'sales_transactions.sales_quantity',
                    'sales_transactions.price_per_item',
                    'sales_transactions.total',
                    'products.product_name'
                )
                ->orderBy('sales_transactions.sales_date', 'asc')
                ->get()
                ->map(function ($item) {
                    $item->sales_date = Carbon::parse($item->sales_date)->toDateString();
                    $item->sales_quantity = (int) $item->sales_quantity;
                    $item->price_per_item = (float) $item->price_per_item;
                    $item->total = (float) $item->total;
                    return $item;
                });

            if ($historicalDataForModel->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data penjualan historis untuk membuat prediksi.'], 404);
            }

            Log::info('Sending data to FastAPI for prediction.', ['url' => $this->fastApiPredictUrl, 'count' => $historicalDataForModel->count()]);

            $response = Http::timeout(180) // Tingkatkan timeout jika perlu (3 menit)
                            ->post($this->fastApiPredictUrl, $historicalDataForModel->toArray());

            Log::info('Received response from FastAPI.', ['status' => $response->status()]);
            // Log::debug('FastAPI Response Body:', ['body' => $response->body()]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Cek jika FastAPI mengembalikan struktur error yang diharapkan { "error": "message" }
                if (isset($responseData['error'])) {
                    Log::error('FastAPI prediction service returned an error', ['response' => $responseData]);
                    return response()->json(['success' => false, 'message' => 'Layanan prediksi mengembalikan error: ' . $responseData['error']], 500);
                }

                // Pastikan struktur utama ada: 'predictions' dan 'last_data_date'
                if (!isset($responseData['predictions']) || !isset($responseData['last_data_date'])) {
                    Log::error('FastAPI response is missing "predictions" or "last_data_date" key.', ['body' => $response->body()]);
                    return response()->json(['success' => false, 'message' => 'Format respons tidak valid dari layanan prediksi (missing keys).'], 500);
                }

                $predictionsArray = $responseData['predictions'];
                $lastDataDateStr = $responseData['last_data_date'];
                $lastDataDate = $lastDataDateStr ? Carbon::parse($lastDataDateStr) : null; // Parse tanggal terakhir jika ada

                // Proses array 'predictions' untuk menambahkan 'type' (historical_model atau predicted_model)
                $processedPredictions = [];
                if (is_array($predictionsArray)) {
                    foreach ($predictionsArray as $item) {
                        // Pastikan item adalah array dan memiliki 'date' dan 'Profit_Per_Day'
                        if (is_array($item) && isset($item['date']) && isset($item['Profit_Per_Day'])) {
                            $itemDate = Carbon::parse($item['date']);
                            if ($lastDataDate && $itemDate->lte($lastDataDate)) {
                                $item['type'] = 'historical_model';
                            } else {
                                $item['type'] = 'predicted_model';
                            }
                            $processedPredictions[] = $item;
                        } else {
                            Log::warning('Skipping invalid item in predictions array from FastAPI', ['item' => $item]);
                        }
                    }
                } else {
                     Log::error('FastAPI "predictions" key is not an array.', ['predictions_type' => gettype($predictionsArray)]);
                     return response()->json(['success' => false, 'message' => 'Format data prediksi tidak valid (bukan array).'], 500);
                }


                return response()->json([
                    'success' => true,
                    'data' => $processedPredictions, // Kirim array yang sudah diproses
                    'last_historical_date_from_model' => $lastDataDateStr // Kirim juga tanggal ini jika JS memerlukannya
                ]);

            } else {
                // Handle error dari FastAPI (status bukan 2xx)
                Log::error('FastAPI request failed', [
                    'url' => $this->fastApiPredictUrl,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $errorMessage = 'Gagal mendapatkan prediksi dari FastAPI.';
                $fastApiError = $response->json();
                if ($fastApiError && isset($fastApiError['error'])) {
                    $errorMessage .= ' Detail: ' . (is_array($fastApiError['error']) ? json_encode($fastApiError['error']) : $fastApiError['error']);
                } elseif($fastApiError && isset($fastApiError['detail'])) { // Untuk error validasi FastAPI default
                    $errorMessage .= ' Detail: ' . (is_array($fastApiError['detail']) ? json_encode($fastApiError['detail']) : $fastApiError['detail']);
                } elseif ($response->body()){
                    $errorMessage .= ' Respons: ' . substr($response->body(), 0, 200);
                }
                return response()->json(['success' => false, 'message' => $errorMessage . ' (Status: ' . $response->status() . ')'], $response->status() ?: 500);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('FastAPI connection error: ' . $e->getMessage(), ['url' => $this->fastApiPredictUrl]);
            return response()->json(['success' => false, 'message' => 'Tidak dapat terhubung ke layanan prediksi: Time out atau koneksi ditolak.'], 503);
        } catch (\Exception $e) {
            Log::error('General error calling FastAPI for prediction: ' . $e->getMessage(), ['url' => $this->fastApiPredictUrl, 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan internal saat memproses prediksi: ' . $e->getMessage()], 500);
        }
    }
    
    public function prediksiProfitView()
    {
        $user = Auth::user();
        return view('penjualan.penjualan_prediksi_profit', compact('user'));
    }

    public function getDailySalesSummary(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        try {
            $query = DB::table('sales_transactions')
                ->join('products', 'sales_transactions.product_id', '=', 'products.product_id')
                ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
                ->where('umkms.user_id', $userId)
                ->select(
                    DB::raw('DATE(sales_transactions.sales_date) as date'),
                    DB::raw('SUM(sales_transactions.total) as total_profit_per_day')
                )
                ->groupBy('date')
                ->orderBy('date', 'asc');

            $dailySales = $query->get()->map(function ($item) {
                $item->date = Carbon::parse($item->date)->toDateString(); // Format YYYY-MM-DD
                $item->type = 'historical_db'; // Tambahkan tipe untuk JS
                $item->Profit_Per_Day = $item->total_profit_per_day;
                unset($item->total_profit_per_day);
                return $item;
            });


            return response()->json([
                'success' => true,
                'data' => $dailySales,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching daily sales summary: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengambil ringkasan penjualan harian.'], 500);
        }
    }

    public function getProfitPredictions(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        if (empty($this->fastApiPredictUrl)) {
            Log::error('FASTAPI_PROFIT_PREDICT_URL is not set in .env file.');
            return response()->json(['success' => false, 'message' => 'FastAPI URL is not configured.'], 500);
        }

        try {
            $historicalDataForModel = DB::table('sales_transactions')
                ->join('products', 'sales_transactions.product_id', '=', 'products.product_id')
                ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
                ->where('umkms.user_id', $userId)
                ->select(
                    'sales_transactions.sales_date',
                    'sales_transactions.sales_quantity',
                    'sales_transactions.price_per_item',
                    'sales_transactions.total',
                    'products.product_name'
                )
                ->orderBy('sales_transactions.sales_date', 'asc')
                ->get()
                ->map(function ($item) {
                    $item->sales_date = Carbon::parse($item->sales_date)->toDateString();
                    $item->sales_quantity = (int) $item->sales_quantity;
                    $item->price_per_item = (float) $item->price_per_item;
                    $item->total = (float) $item->total;
                    return $item;
                });

            if ($historicalDataForModel->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data penjualan historis untuk membuat prediksi.'], 404);
            }

            Log::info('Sending data to FastAPI for prediction.', ['url' => $this->fastApiPredictUrl, 'count' => $historicalDataForModel->count()]);

            $response = Http::timeout(180) // Tingkatkan timeout jika perlu (3 menit)
                            ->post($this->fastApiPredictUrl, $historicalDataForModel->toArray());

            Log::info('Received response from FastAPI.', ['status' => $response->status()]);
            // Log::debug('FastAPI Response Body:', ['body' => $response->body()]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Cek jika FastAPI mengembalikan struktur error yang diharapkan { "error": "message" }
                if (isset($responseData['error'])) {
                    Log::error('FastAPI prediction service returned an error', ['response' => $responseData]);
                    return response()->json(['success' => false, 'message' => 'Layanan prediksi mengembalikan error: ' . $responseData['error']], 500);
                }

                // Pastikan struktur utama ada: 'predictions' dan 'last_data_date'
                if (!isset($responseData['predictions']) || !isset($responseData['last_data_date'])) {
                    Log::error('FastAPI response is missing "predictions" or "last_data_date" key.', ['body' => $response->body()]);
                    return response()->json(['success' => false, 'message' => 'Format respons tidak valid dari layanan prediksi (missing keys).'], 500);
                }

                $predictionsArray = $responseData['predictions'];
                $lastDataDateStr = $responseData['last_data_date'];
                $lastDataDate = $lastDataDateStr ? Carbon::parse($lastDataDateStr) : null; // Parse tanggal terakhir jika ada

                // Proses array 'predictions' untuk menambahkan 'type' (historical_model atau predicted_model)
                $processedPredictions = [];
                if (is_array($predictionsArray)) {
                    foreach ($predictionsArray as $item) {
                        // Pastikan item adalah array dan memiliki 'date' dan 'Profit_Per_Day'
                        if (is_array($item) && isset($item['date']) && isset($item['Profit_Per_Day'])) {
                            $itemDate = Carbon::parse($item['date']);
                            if ($lastDataDate && $itemDate->lte($lastDataDate)) {
                                $item['type'] = 'historical_model';
                            } else {
                                $item['type'] = 'predicted_model';
                            }
                            $processedPredictions[] = $item;
                        } else {
                            Log::warning('Skipping invalid item in predictions array from FastAPI', ['item' => $item]);
                        }
                    }
                } else {
                     Log::error('FastAPI "predictions" key is not an array.', ['predictions_type' => gettype($predictionsArray)]);
                     return response()->json(['success' => false, 'message' => 'Format data prediksi tidak valid (bukan array).'], 500);
                }


                return response()->json([
                    'success' => true,
                    'data' => $processedPredictions, // Kirim array yang sudah diproses
                    'last_historical_date_from_model' => $lastDataDateStr // Kirim juga tanggal ini jika JS memerlukannya
                ]);

            } else {
                // Handle error dari FastAPI (status bukan 2xx)
                Log::error('FastAPI request failed', [
                    'url' => $this->fastApiPredictUrl,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $errorMessage = 'Gagal mendapatkan prediksi dari FastAPI.';
                $fastApiError = $response->json();
                if ($fastApiError && isset($fastApiError['error'])) {
                    $errorMessage .= ' Detail: ' . (is_array($fastApiError['error']) ? json_encode($fastApiError['error']) : $fastApiError['error']);
                } elseif($fastApiError && isset($fastApiError['detail'])) { // Untuk error validasi FastAPI default
                    $errorMessage .= ' Detail: ' . (is_array($fastApiError['detail']) ? json_encode($fastApiError['detail']) : $fastApiError['detail']);
                } elseif ($response->body()){
                    $errorMessage .= ' Respons: ' . substr($response->body(), 0, 200);
                }
                return response()->json(['success' => false, 'message' => $errorMessage . ' (Status: ' . $response->status() . ')'], $response->status() ?: 500);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('FastAPI connection error: ' . $e->getMessage(), ['url' => $this->fastApiPredictUrl]);
            return response()->json(['success' => false, 'message' => 'Tidak dapat terhubung ke layanan prediksi: Time out atau koneksi ditolak.'], 503);
        } catch (\Exception $e) {
            Log::error('General error calling FastAPI for prediction: ' . $e->getMessage(), ['url' => $this->fastApiPredictUrl, 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan internal saat memproses prediksi: ' . $e->getMessage()], 500);
        }
    }
}
