<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Cart;
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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('dashboard');
        Route::get('/product', [ProductController::class, 'getProduct'])->name('product');
        Route::post('/product', [ProductController::class, 'storeProduct'])->name('storeProduct');
        Route::get('/seller/products/{id}/edit', [ProductController::class, 'editProduct'])->name('seller.editProduct');
        Route::put('/seller/products/{id}', [ProductController::class, 'updateProduct'])->name('seller.updateProduct');
        Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        Route::get('/order', [OrderController::class, 'getOrder'])->name('order');
    });

    Route::prefix('/')->name('home.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('dashboard');
        Route::post('/', [CartController::class, 'storeCart'])->name('store');
        Route::delete('/{id}', [CartController::class, 'deleteChart'])->name('delete');
    });

    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('dashboard');
        Route::post('/', [HistoryController::class, 'checkout'])->name('checkout');
        Route::get('/detail/{id}', [HistoryController::class, 'detailCheckout'])->name('detail');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});