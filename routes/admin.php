<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Inertia::render('Admin/Dashboard');
})->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Admin/Dashboard');
})->name('products');

Route::prefix('categories')->group(function (){
    Route::get('/', function () {
        return Inertia::render('Admin/Categories/Index');
    })->name('categories.index');

    Route::get('/create', function () {
        return Inertia::render('Admin/Categories/Create');
    })->name('categories.create');
});

require __DIR__.'/auth.php';
