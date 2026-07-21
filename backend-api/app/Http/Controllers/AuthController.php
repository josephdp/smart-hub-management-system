<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // 4. Buat Token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kembalikan response JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => $user
        ], 200);
    }
}