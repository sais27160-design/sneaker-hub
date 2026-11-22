
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SneakerController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/sneakers', [SneakerController::class, 'index'])->name('sneakers.index');

require __DIR__.'/settings.php';
