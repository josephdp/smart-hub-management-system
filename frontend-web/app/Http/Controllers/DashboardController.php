<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        // Menembak API Backend port 8000 dengan menyertakan Bearer Token
        $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/equipments');

        // Mengambil data dari respons API
        $equipments = [];
        if ($response->successful()) {
            $data = $response->json();
            // Menyesuaikan struktur JSON (bisa berupa array langsung atau di dalam key 'data')
            $equipments = is_array($data) ? ($data['data'] ?? $data) : [];
        }

        return Inertia::render('Dashboard', [
            'equipments' => $equipments
        ]);
    }
}