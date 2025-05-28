<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

// HOME
//Route::get('/', [HomeController::class, 'index'])->name('users.home');

// CART (hanya bisa diakses jika login)
//Route::resource('cart', CartController::class)->only([
    //'index', 'store', 'destroy'
//])->middleware('auth');

// AUTH: Web-based Login/Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'registerWeb'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login');

Route::post('/logout', [AuthController::class, 'logoutWeb'])->middleware('auth')->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth');

// Dashboard setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
