<?php

namespace App\Http\Controllers;

use App\Models\Umkaem;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function getDataUmkm(Request $request)
    {
        $umkm = $request->query('name');

        $querry = Umkaem::join('users', 'umkms.user_id', '=', 'users.id')
            ->where('is_verified', 1)
            ->where('users.status', 'active')
            ->select('users.id', 'users.name', 'users.login_at', 'umkms.forecasting_demand', 'umkms.buffer_stock', 'users.status')
            ->orderBy('users.created_at', 'desc');

        if ($umkm) {
            $querry->where('users.name', 'like', '%' . $umkm . '%');
        }

        $umkms = $querry->paginate(10);

        // Hitung durasi aktif (dalam menit) untuk setiap item
        $data = $umkms->map(function ($item) {
            if ($item->login_at) {
                $loginTime = Carbon::parse($item->login_at);
                $now = now();
                $durationInMinutes = (int) $loginTime->diffInMinutes($now);
            } else {
                $durationInMinutes = 0;
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'forecasting_demand' => $item->forecasting_demand,
                'buffer_stock' => $item->buffer_stock,
                'durasi' => $durationInMinutes,
                'status' => $item->status,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
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

    public function tolakVerifikasiUmkm(Request $request)
    {
        $umkm = Umkaem::find($request->id);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM tidak ditemukan'], 404);
        }

        $user = User::find($umkm->user_id);
        if ($user) {
            Mail::send('emails.verify_umkm_cancel', ['name' => $user->name, 'messageCancel' => $request->messageCancel], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Verifikasi UMKM Ditolak');
            });
            $user->delete();
        }

        return response()->json([
            'message' => 'UMKM ditolak verifikasinya'
        ], 200);
    }

    public function getDataUmkmActiveInactive()
    {
        $umkmActive = User::where('role', 'umkm')->where('status', 'active')->count();
        $umkmInactive = User::where('role', 'umkm')->where('status', 'deleted')->count();
        return response()->json([
            'status' => 'success',
            'data' => [
                'active' => $umkmActive,
                'inactive' => $umkmInactive,
            ]
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
