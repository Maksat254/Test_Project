<?php

use App\Http\Controllers\API\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
    Route::post('/api/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');

});

