
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SneakerController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/sneakers', [SneakerController::class, 'index'])->name('sneakers.index');

Route::post('/sneakers', [SneakerController::class, 'handleAction'])
    ->name('sneakers.action');

    // Shopping Cart
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/update', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');

require __DIR__.'/settings.php';
