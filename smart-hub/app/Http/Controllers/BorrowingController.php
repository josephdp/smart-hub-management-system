<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeminjamanNotification;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkIn(Request $request, $id)
    {
        $borrowing = \App\Models\Borrowing::findOrFail($id);

        $borrowing->update([
            'status' => 'checked_in',
            'return_time' => now()
        ]);

        // Perintah untuk memicu pengiriman email
        Mail::to('admin@smarthub.com')->send(new PeminjamanNotification($borrowing));

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil diproses dan notifikasi telah dikirim'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
