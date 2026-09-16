<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AuthorController;

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is running',
    ]);
});


Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class,'logout']);
        Route::get('/me', [AuthController::class,'me']);

    });

});

Route::apiResource('authors', AuthorController::class)
    ->only(['index', 'show']);


Route::middleware('auth:sanctum')
    ->apiResource('authors', AuthorController::class)
    ->except(['index', 'show']);