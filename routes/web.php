<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SneakerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminSneakerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Storefront
Route::get('/sneakers', [SneakerController::class, 'index'])->name('sneakers.index');
Route::post('/sneakers', [SneakerController::class, 'handleAction'])->name('sneakers.action');

// Shopping cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Admin store management
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminSneakerController::class, 'index'])->name('dashboard');
    Route::post('/sneakers', [AdminSneakerController::class, 'store'])->name('sneakers.store');
    Route::put('/sneakers/{sneaker}', [AdminSneakerController::class, 'update'])->name('sneakers.update');
    Route::delete('/sneakers/{sneaker}', [AdminSneakerController::class, 'destroy'])->name('sneakers.destroy');
});

require __DIR__.'/settings.php';
