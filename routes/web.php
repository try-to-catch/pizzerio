<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Category\ShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', HomeController::class)->name('home');

Route::get('/categories/{category:slug}', ShowController::class)->name('categories.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('cart')->controller(CartController::class)->name('cart.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'add')->name('add');
    Route::patch('/{productId}', 'update')->name('update');
    Route::delete('/{productId}', 'remove')->name('remove');
});

Route::prefix('order')->controller(OrderController::class)->name('order.')->group(function () {
    Route::post('/store', 'store')->name('store');
});


require __DIR__.'/auth.php';
