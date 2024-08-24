<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/product', [ProductController::class, 'getProduct'])->name('allProduct');
    Route::get('/product/{id}', [ProductController::class, 'getProductById'])->name('productById');
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::post('/product', [ProductController::class, 'storeProduct'])->name('storeProduct');
    Route::put('/product/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');

    Route::get('/order', [OrderController::class, 'getOrder'])->name('getOrder');
    Route::get('/order/{id}', [OrderController::class, 'detailOrder'])->name('detailOrder');
    Route::put('/order/{id}', [OrderController::class, 'updateOrder'])->name('updateOrder');

    Route::get('/cart', [CartController::class, 'getCart'])->name('getCart');
    Route::post('/cart', [CartController::class, 'addCart'])->name('addCart');
    Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('deleteCart');

    Route::get('/checkout', [CheckoutController::class, 'getCheckout'])->name('getCheckout');
    Route::post('/checkout', [CheckoutController::class, 'addCheckout'])->name('addCheckout');
    Route::get('/checkout/{id}', [CheckoutController::class, 'detailCheckout'])->name('detailCheckout');

    Route::post('/logout', [AuthController::class, 'logout']);
});