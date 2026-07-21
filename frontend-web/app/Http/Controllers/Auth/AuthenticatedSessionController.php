<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    // 1. Tembak API Backend menggunakan Http Client Laravel
    $response = Http::post('http://127.0.0.1:8000/api/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    // 2. Jika Backend bilang sukses dan mengembalikan Token
    if ($response->successful() && $response->json('status') === 'success') {

        // Simpan Token dan Data User ke dalam brankas (session) Frontend
        session(['api_token' => $response->json('token')]);
        session(['api_user' => $response->json('user')]);

        // Arahkan ke halaman Dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }

    // 3. Jika gagal, kembalikan pesan error ke tampilan Vue
    throw ValidationException::withMessages([
        'email' => 'Email atau password salah, atau API tidak terhubung.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
{
    // Hapus semua token di session frontend lalu kembalikan ke halaman awal
    session()->flush();
    return redirect('/');
}
}
