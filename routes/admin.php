<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Admin/Dashboard');
})->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Admin/Dashboard');
})->name('products');

Route::bind('category', function ($value) {
    return Category::where('slug', $value)->firstOrFail();
});

Route::resource('categories', CategoryController::class);

require __DIR__ . '/auth.php';
