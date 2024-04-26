<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/news', [NewsApiController::class, 'index'])->name('newsApi.index');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
