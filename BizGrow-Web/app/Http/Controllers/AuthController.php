<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkaem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'npwp' => 'required|max:25',
            'file_surat_izin' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Simpan ke tabel users
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Simpan file dan buat path-nya
            $filePath = $request->file('file_surat_izin')->store('public/surat_izin');

            // Simpan ke tabel umkms
            $umkm = Umkaem::create([
                'user_id' => $user->id,
                'npwp_no' => $data['npwp'],
                'izin_usaha_path' => $filePath,
            ]);

            DB::commit(); // Jika semua berhasil, commit transaksi

            return response()->json([
                'message' => 'Register berhasil!',
                'data' => [
                    'user' => $user,
                    'umkm' => $umkm,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Jika terjadi error, rollback transaksi
            return response()->json(['error' => 'Terjadi kesalahan saat register'], 500);
        }

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // Menghapus token milik pengguna yang sedang login
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'You have been logged out successfully',
        ]);
    }

    public function signinView()
    {
        return view('autentikasi.signin'); // Blade view
    }

    public function signupView()
    {
        return view('autentikasi.signup'); // Blade view
    }

    public function signoutView()
    {
        return view('autentikasi.signin'); // Blade view
    }
}
