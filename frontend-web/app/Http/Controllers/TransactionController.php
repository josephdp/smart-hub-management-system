<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil data transaksi dari API Backend dengan menyertakan cookie/session aktif
        $response = Http::acceptJson()->get('http://127.0.0.1:8000/api/transactions');
        
        $transactions = [];
        if ($response->successful()) {
            $data = $response->json();
            $transactions = $data['data'] ?? [];
        }

        return Inertia::render('Transactions', [
            'transactions' => $transactions
        ]);
    }
}