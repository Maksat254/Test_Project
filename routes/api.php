<?php
namespace App\Http\Api\Controllers;

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
