<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route untuk profile yang membutuhkan autentikasi menggunakan API token
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route logout untuk menghapus token
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
