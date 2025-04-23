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
    public function getDataUmkm()
    {
        $querry = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('is_verified', 1)
            ->where('users.status', 'active')
            ->select('users.id', 'users.name', 'umkms.durasi', 'umkms.forecasting_demand', 'umkms.buffer_stock', 'users.status')
            ->orderBy('users.created_at', 'desc');

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

    public function getDataUmkmVerification()
    {
        $querry = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('is_verified', 0)
            ->where('users.status', 'active')
            ->select('users.id', 'users.name', 'umkms.is_verified', 'umkms.npwp_no', 'umkms.izin_usaha_path')
            ->orderBy('users.created_at', 'desc');

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

    public function dataUmkmView()
    {
        return view('admin.data_umkm'); // Blade view
    }

    public function umkmVerificationView()
    {
        return view('umkm.verifikasi'); // Blade view
    }

}
