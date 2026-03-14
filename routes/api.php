<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ImageGenerationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Server\Resource;

Route::prefix('/v1')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.get');
    Route::post('/users', [UserController::class, 'store'])->name('user.create');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.find');

    // Route::apiResource('orders', OrderController::class);

    Route::post('/orders', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/check', [OrderController::class, 'check'])->name('orders.check');
});