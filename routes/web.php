<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('adminOrAuthor')->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comment.store');
});

Route::middleware('adminOrNewsAuthor')->group(function () {
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
});

Route::get('/', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::post('/news/{news}/rating', [NewsController::class, 'rating'])->name('news.rating');

Route::middleware('registeredUser')->group(function () {
    Route::get('/news/{comment}/like-status', [CommentController::class, 'setLikeStatus'])->name('comment.setLikeStatus');
});

Route::middleware('admin')->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
});

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

Auth::routes();
