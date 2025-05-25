<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\OrderController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Cek user login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// PUBLIC ROUTES (tidak harus login)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// PROTECTED ROUTES (harus login)
Route::middleware('auth:sanctum')->group(function () {

    // User Cart
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'addItem']);
    Route::put('cart/update/{id}', [CartController::class, 'update']);
    Route::delete('cart/remove/{id}', [CartController::class, 'destroy']);


    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        // Route::apiResource('orders', OrderController::class);
    });
});
