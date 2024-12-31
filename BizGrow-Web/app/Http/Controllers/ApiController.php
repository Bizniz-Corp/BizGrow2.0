<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    // Endpoint untuk fetch semua produk
    public function getAllProducts()
    {
        try {
            $products = Product::all();
            return response()->json([
                'success' => true,
                'data' => $products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Endpoint untuk fetch satu produk berdasarkan ID
    public function getProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
                'error' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Product not found' : $e->getMessage(),
            ], 404);
        }
    }

    public function getSalesHistory()
    {
        $userId = Auth::id();

        $salesHistory = SalesTransaction::join('products', 'sales_transactions.product_id', '=', 'products.product_id')
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
            ->get();

        return response()->json([
            'success' => true,
            'data' => $salesHistory,
        ], 200);

    }

    public function getStockHistory()
    {
        $userId = Auth::id();

        $salesHistory = PurchaseTransaction::join('products', 'purchase_transactions.product_id', '=', 'products.product_id')
            ->join('umkms', 'products.umkm_id', '=', 'umkms.umkm_id')
            ->where('umkms.user_id', $userId)
            ->select(
                'purchase_transactions.purchase_id',
                'products.product_name',
                'purchase_transactions.purchase_date',
                'purchase_transactions.purchase_quantity',
                'purchase_transactions.price_per_item',
                'purchase_transactions.total'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $salesHistory,
        ], 200);

    }

    // ambil data user yang sedang login dan dibutuhkan profile hehe
    public function getProfile()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'npwp' => $umkm->npwp_no,
            ],
        ], 200);
    }

    // update data user yang sedang login
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        DB::beginTransaction();

        try {
            // Update user data
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->save();

            DB::commit(); 

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui profil'], 500);
        }
    }

    public function deleteProfile(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Hapus user
            $user->status = 'deleted';
            $user->save();

            DB::commit(); 

            return response()->json([
                'success' => true,
                'message' => 'Profile deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus profil'], 500);
        }
    }
}
