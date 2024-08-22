<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/product', [ProductController::class, 'getProduct'])->name('product');
    Route::get('/order', [OrderController::class, 'getOrder'])->name('order');
});

Route::prefix('home')->name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('dashboard');
});

Route::prefix('history')->name('history.')->group(function () {
    Route::get('/', [HistoryController::class, 'index'])->name('dashboard');
});