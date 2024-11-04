<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PersonalCabinetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/news/all', [NewsController::class, 'allNews'])->name('news.all');
Route::get('/cabinet/unapproved/{userId}', [PersonalCabinetController::class, 'myUnapprovedNews'])->name('cabinet.unapprovedNews');
Route::get('/cabinet/unapprovedNews/{id}/edit', [PersonalCabinetController::class, 'editUnapprovedNews'])->name('cabinet.editUnapprovedNews');
Route::put('/cabinet/unapprovedNews/{id}', [PersonalCabinetController::class, 'updateUnapprovedNews'])->name('cabinet.updateUnapprovedNews');
Route::get('/cabinet/rejection/{id}', [PersonalCabinetController::class, 'myRejectionNews'])->name('cabinet.rejectionNews');

Route::middleware('adminOrAuthor')->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/cabinet/publications', [PersonalCabinetController::class, 'myPublication'])->name('cabinet.publications');

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
    Route::get('/cabinet', [PersonalCabinetController::class, 'index'])->name('cabinet.index');
    Route::get('/news/{comment}/like-status', [CommentController::class, 'setLikeStatus'])->name('comment.setLikeStatus');
    Route::get('/cabinet/edit', [\App\Http\Controllers\Admin\PersonalCabinetController::class, 'edit'])->name('cabinet.edit');
    Route::put('/cabinet', [\App\Http\Controllers\Admin\PersonalCabinetController::class, 'update'])->name('cabinet.update');
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comment.store');
});

Route::middleware('admin')->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/admin', [AdminController::class, 'allPublications'])->name('admin.allPublications');
    Route::get('/admin/comment', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comment.index');
    Route::get('/admin/comment/{comment}/edit', [\App\Http\Controllers\Admin\CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/admin/comment/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'update'])->name('comment.update');
    Route::get('/admin/create', [\App\Http\Controllers\Admin\TagController::class, 'create'])->name('tag.create');
    Route::post('admin/store', [\App\Http\Controllers\Admin\TagController::class, 'store'])->name('tag.store');
    Route::put('/user/{user}/block', [UserController::class, 'block'])->name('user.block');
    Route::get('/admin/untested', [AdminController::class, 'untested'])->name('admin.untestedNews');
    Route::post('/admin/approved/{id}', [AdminController::class, 'check'])->name('admin.check');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
});

    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('news/tag/{tag}', [NewsController::class, 'showTag'])->name('news.tag');



