<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkaem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'npwp' => 'required|size:16',
            'file_surat_izin' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.regex' => 'Password harus mengandung huruf kapital dan angka.',
            'password.min' => 'Password minimal 8 karakter.',
            'file_surat_izin.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_surat_izin.max' => 'File maksimal 2MB.',
            'npwp.required' => 'NPWP harus diisi.',
            'npwp.size' => 'NPWP harus 16 karakter.',
            'file_surat_izin.required' => 'File surat izin harus diunggah.',
            'file_surat_izin.file' => 'File harus berupa file.',
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

            // Foto profile default
            $defaultProfilePhoto = basename(asset('storage/default_avatar.jpg'));

            // Simpan ke tabel umkms
            $umkm = Umkaem::create([
                'user_id' => $user->id,
                'npwp_no' => $data['npwp'],
                'izin_usaha_path' => $filePath,
                'profile_picture' => $defaultProfilePhoto,
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
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password harus diisi.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah!'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Menghapus token milik pengguna yang sedang login
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'You have been logged out successfully',
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem kami.'
        ]);

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

    public function forgotPasswordView()
    {
        return view('autentikasi.forgot-password'); // Blade view
    }
    public function otpView()
    {
        return view('autentikasi.otp'); // Blade view
    }
}
