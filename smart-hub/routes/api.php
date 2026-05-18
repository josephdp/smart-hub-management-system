<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

// Mengambil data inventaris (GET)
Route::get('/equipments', [EquipmentController::class, 'index']);

// Proses check-in peminjaman dari tablet (PUT)
Route::put('/check-in/{id}', [BorrowingController::class, 'checkIn']);
