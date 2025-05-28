<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\RecommendationController;
use App\Http\Controllers\Public\PublicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔐 AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🌐 PUBLIC ROUTES (Homepage / User tidak login)
Route::get('/homepage', [PublicController::class, 'homepage']); // berisi banner, kategori, rekomendasi, popular, dan produk
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

//Harus butuh login
Route::middleware('auth:sanctum')->group(function () {

    //🛒 USER CART 
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'addItem']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy']);

    //📍 ADDRESSES
    Route::get('/addresses', [\App\Http\Controllers\API\AddressController::class, 'index']);
    Route::post('/addresses', [\App\Http\Controllers\API\AddressController::class, 'store']);
    Route::put('/addresses/{id}', [\App\Http\Controllers\API\AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [\App\Http\Controllers\API\AddressController::class, 'destroy']);

    //Checkout Produk
    Route::post('/checkout', [\App\Http\Controllers\API\OrderController::class, 'checkout']);
    Route::get('/orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
    Route::get('/orders/{id}', [\App\Http\Controllers\API\OrderController::class, 'show']);
    Route::put('/orders/{id}/status', [\App\Http\Controllers\API\OrderController::class, 'updateStatus']);
    Route::post('/orders/{id}/cancel', [\App\Http\Controllers\API\OrderController::class, 'cancel']);


    // 🔐 ADMIN ROUTES
    Route::middleware('admin')->group(function () {
        // Produk & Kategori
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);

        // Ubah status 
        Route::put('/orders/{id}/status', [\App\Http\Controllers\API\OrderController::class, 'updateStatus']);

        // Banner
        Route::prefix('admin')->group(function () {
            Route::get('banner', [BannerController::class, 'index']);
            Route::post('banner', [BannerController::class, 'store']);
            Route::get('banner/{id}', [BannerController::class, 'show']);
            Route::put('banner/{id}', [BannerController::class, 'update']);
            Route::delete('banner/{id}', [BannerController::class, 'destroy']);

            // Rekomendasi Produk
            Route::get('recommendations', [RecommendationController::class, 'index']);
            Route::post('recommendations', [RecommendationController::class, 'store']);
            Route::delete('recommendations/{product}', [RecommendationController::class, 'destroy']);
        });
    });
});
