<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ProductController;
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



Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home',[ProductController::class,'index'])->name('home');
    Route::post('/cart',[ProductController::class,'addToCart'])->name('cart.add');
    Route::delete('/cart',[ProductController::class,'removeFromCart'])->name('cart.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
