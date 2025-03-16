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

    public function verifikasiUmkm($id, Request $request)
    {
        $umkm = Umkaem::find($request->id);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM tidak ditemukan'], 404);
        }

        $umkm->is_verified = 1;
        $umkm->save();

        return response()->json([
            'status' => 'success',
            'message' => 'UMKM berhasil diverifikasi'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate token unik
        $token = Str::random(60);

        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Kirim email ke user
        Mail::send('emails.forgot_password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Request');
        });

        return response()->json(['message' => 'Link reset password telah dikirim ke email!']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%^&*]/',
        ]);

        // Cek token
        $resetData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$resetData) {
            return response()->json(['message' => 'Token tidak valid'], 400);
        }

        // Update password user
        $user = User::where('email', $resetData->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $resetData->email)->delete();

        return response()->json(['message' => 'Password berhasil direset!']);
    }

}
