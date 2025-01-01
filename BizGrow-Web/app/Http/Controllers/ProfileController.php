<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
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
    public function checkPassword(Request $request)
    {
        $request->validate([
            'passLama' => 'required',
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->passLama, $user->password)) {
            return response()->json([
                'message' => 'Password lama tidak valid.'
            ], 401);
        }

        return response()->json([
            'message' => 'Password lama valid.'
        ], 200);

    }

    public function editPassword(Request $request)
    {
        try {
            $request->validate([
                'passBaru' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%^&*]/',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan.'
                ], 404);
            }

            // Update password
            $user->password = Hash::make($request->passBaru);
            $user->save();

            return response()->json([
                'message' => 'Password berhasil diubah.'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'request' => $request->all(),
                'error' => $e->errors()
            ], 422);
        }

    }

    public function profilView()
    {
        return view('profil.profile'); // Blade view
    }

    public function profilEditView()
    {
        return view('profil.profile_edit'); // Blade view
    }

    public function profilEditPasswordView()
    {
        return view('profil.edit_password'); // Blade view
    }
}
