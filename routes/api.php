<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ImageGenerationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'throttle:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return User::all();
    });

    Route::prefix('v1')->group(function () {
        Route::apiResource('posts', PostController::class);

        Route::apiResource('image-generations', ImageGenerationController::class)
        ->only(['index', 'store']);
    });
});


require __DIR__.'/auth.php';


