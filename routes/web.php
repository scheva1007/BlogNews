<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PersonalCabinetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/news/all', [NewsController::class, 'allNews'])->name('news.all');

Route::middleware('adminOrAuthor')->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/cabinet/publications', [PersonalCabinetController::class, 'myPublication'])->name('cabinet.publications');
    Route::get('/cabinet/unapproved', [PersonalCabinetController::class, 'myUnapprovedNews'])->name('cabinet.unapprovedNews');
    Route::get('/cabinet/rejection', [PersonalCabinetController::class, 'myRejectionNews'])->name('cabinet.rejectionNews');
});

Route::middleware('adminOrNewsAuthor')->group(function () {
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::get('/cabinet/unapprovedNews/{news}/edit', [PersonalCabinetController::class, 'editUnapprovedNews'])->name('cabinet.editUnapprovedNews');
    Route::put('/cabinet/unapprovedNews/{news}', [PersonalCabinetController::class, 'updateUnapprovedNews'])->name('cabinet.updateUnapprovedNews');
});

Route::get('/', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::post('/news/{news}/rating', [NewsController::class, 'rating'])->name('news.rating');

Route::middleware('registeredUser')->group(function () {
    Route::get('/cabinet', [PersonalCabinetController::class, 'index'])->name('cabinet.index');
    Route::get('/news/{comment}/like-status', [CommentController::class, 'setLikeStatus'])->name('comment.setLikeStatus');
    Route::get('/cabinet/edit', [\App\Http\Controllers\Admin\PersonalCabinetController::class, 'edit'])->name('cabinet.edit');
    Route::get('/notification', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notification.index');
    Route::put('/cabinet', [\App\Http\Controllers\Admin\PersonalCabinetController::class, 'updatePersonalInfo'])->name('cabinet.update');
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/subscribe/{author}', [SubscriptionController::class, 'subscribe'])->name('subscribe.subscribe');
    Route::post('/unsubscribe/{author}', [SubscriptionController::class, 'unsubscribe'])->name('subscribe.unsubscribe');
    Route::post('/notification/changeStatus', [NotificationController::class, 'changeStatusNotification'])->name('notification.changeStatus');
});

Route::middleware('admin')->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/admin', [AdminController::class, 'allPublications'])->name('admin.allPublications');
    Route::get('/admin/comment', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comment.index');
    Route::get('/admin/comment/{comment}/edit', [\App\Http\Controllers\Admin\CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/admin/comment/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'update'])->name('comment.update');
    Route::get('/admin/create', [\App\Http\Controllers\Admin\TagController::class, 'create'])->name('tag.create');
    Route::post('admin/store', [\App\Http\Controllers\Admin\TagController::class, 'store'])->name('tag.store');
    Route::put('/user/{user}/block', [UserController::class, 'block'])->name('user.block');
    Route::get('/admin/unchecked', [AdminController::class, 'unchecked'])->name('admin.uncheckedNews');
    Route::post('/admin/approved/{news}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{news}', [AdminController::class, 'reject'])->name('admin.reject');
});

    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('news/tag/{tag}', [NewsController::class, 'showTag'])->name('news.tag');



