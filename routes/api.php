<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PersonaCabinetApiController;
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
    Route::put('/cabinet/update', [PersonaCabinetApiController::class, 'update'])->name('personalCabinetControllerApi.update');
    Route::get('/cabinet/publication', [PersonaCabinetApiController::class, 'myPublication'])->name('personalCabinetControllerApi.publication');
    Route::get('/cabinet/unApprovedNews', [PersonaCabinetApiController::class, 'myUnapprovedNews'])->name('personalCabinetControllerApi.unApprovedNews');
    Route::get('/cabinet/rejectionNews', [PersonaCabinetApiController::class, 'myRejectionNews'])->name('personalCabinetControllerApi.rejectionNews');
    Route::put('/cabinet/unapprovedNews/{news}', [PersonaCabinetApiController::class, 'updateUnapprovedNews'])->name('personalCabinetControllerApi.updateUnapprovedNews');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/news', [NewsApiController::class, 'index'])->name('newsApi.index');
Route::get('/news/{news}', [NewsApiController::class, 'show'])->name('newsApi.show');


