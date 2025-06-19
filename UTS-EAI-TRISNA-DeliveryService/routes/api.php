<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Menggunakan apiResource untuk mendaftarkan semua endpoint CRUD
Route::apiResource('/deliveries', DeliveryController::class);
