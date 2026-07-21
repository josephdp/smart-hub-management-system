<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TransactionController;

// Rute Publik (Tanpa Login)
Route::post('/login', [AuthController::class, 'login']);

// Rute yang Memerlukan Autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Equipment Routes
    Route::get('/equipments', [EquipmentController::class, 'index']);
    Route::post('/equipments', [EquipmentController::class, 'store']);
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'destroy']);
    
    // Check-in Route
    Route::put('/check-in/{id}', [BorrowingController::class, 'checkIn']);

    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);
});