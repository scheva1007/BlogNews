<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('adminOrNewsAuthor')->group(function () {
        Route::put('/news/{news}', [NewsApiController::class, 'update'])->name('newsApi.update');
        Route::delete('/news/{news}', [NewsApiController::class, 'destroy'])->name('newsApi.destroy');
    });

    Route::middleware('adminOrAuthor')->group(function () {
        Route::post('/news', [NewsApiController::class, 'store'])->name('newsApi.store');
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/news', [NewsApiController::class, 'index'])->name('newsApi.index');
Route::get('/news/{news}', [NewsApiController::class, 'show'])->name('newsApi.show');
