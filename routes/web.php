<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/products', [ProductController::class, 'index'])->name('product.index');
