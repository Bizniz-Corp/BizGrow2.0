<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
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
