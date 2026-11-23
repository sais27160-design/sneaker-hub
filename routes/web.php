
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SneakerController;


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

require __DIR__.'/settings.php';
