<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkaem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UmkmController extends Controller
{
    public function getDataUmkm(Request $request)
    {
        $umkm = $request->query('name');

        $querry = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('is_verified', 1)
            ->where('users.status', 'active')
            ->select('users.id', 'users.name', 'umkms.durasi', 'umkms.forecasting_demand', 'umkms.buffer_stock', 'users.status')
            ->orderBy('users.created_at', 'desc');

        if ($umkm) {
            $querry->where('users.name', 'like', '%' . $umkm . '%');
        }

        $umkms = $querry->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $umkms->items(),
            'pagination' => [
                'current_page' => $umkms->currentPage(),
                'last_page' => $umkms->lastPage(),
                'per_page' => $umkms->perPage(),
                'total' => $umkms->total(),
            ],
        ], 200);
    }

    public function deleteUmkm($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        $user->status = User::STATUS_DELETED;
        $user->save();
        return response()->json([
            'message' => "User berhasil dihapus dengan ID $id"
        ], 200);
    }

    public function getDataUmkmVerification(Request $request)
    {
        $umkm = $request->query('name');

        $querry = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('is_verified', 0)
            ->where('users.status', 'active')
            ->select('users.id', 'users.name', 'umkms.is_verified', 'umkms.npwp_no', 'umkms.izin_usaha_path')
            ->orderBy('users.created_at', 'desc');

        if ($umkm) {
            $querry->where('users.name', 'like', '%' . $umkm . '%');
        }

        $umkms = $querry->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $umkms->items(),
            'pagination' => [
                'current_page' => $umkms->currentPage(),
                'last_page' => $umkms->lastPage(),
                'per_page' => $umkms->perPage(),
                'total' => $umkms->total(),
            ],
        ], 200);
    }

    public function verifikasiUmkm(Request $request)
    {
        $umkm = Umkaem::find($request->id);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM tidak ditemukan'], 404);
        }

        $umkm->is_verified = 1;
        $umkm->save();

        // Kirim email notifikasi ke UMKM
        $user = User::find($umkm->user_id);
        if ($user) {
            Mail::send('emails.verify_umkm', ['name' => $user->name], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Verifikasi UMKM Berhasil');
            });
        }

        return response()->json([
            'message' => 'UMKM berhasil diverifikasi'
        ], 200);
    }
    public function getUmkmStats()
    {
        $activeUmkmCount = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('umkms.is_verified', 1)
            ->where('users.status', 'active')
            ->count();

        $inactiveUmkmCount = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('umkms.is_verified', 1)
            ->where('users.status', 'deleted')
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'active_umkm_count' => $activeUmkmCount,
                'inactive_umkm_count' => $inactiveUmkmCount,
            ],
        ], 200);
    }
    public function dataUmkmView()
    {
        return view('admin.data_umkm'); // Blade view
    }

    public function umkmVerificationView()
    {
        return view('admin.verifikasi'); // Blade view
    }

    public function feedbackView()
    {
        return view('admin.feedback'); // Blade view
    }

}
