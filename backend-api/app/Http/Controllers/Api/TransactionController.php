<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. LIST: Menampilkan daftar seluruh transaksi peminjaman beserta relasi alat dan user-nya
    public function index()
    {
        $borrowings = Borrowing::with(['equipment', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ], 200);
    }

    // 2. CREATE: Membuat transaksi peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'user_id' => 'required|exists:users,id',
            'borrow_time' => 'required|date',
            'status' => 'required|string',
        ]);

        $borrowing = Borrowing::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Transaksi peminjaman berhasil dibuat',
            'data' => $borrowing
        ], 201);
    }

    // 3. UPDATE: Memperbarui data transaksi (misal mengubah status atau waktu)
    public function update(Request $request, Borrowing $transaction)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $transaction->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Status transaksi berhasil diperbarui',
            'data' => $transaction
        ], 200);
    }
}