<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminRegistationController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController;


Route::middleware(['AdminAuth'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    // blog management
    Route::get('/blog/add', [BlogController::class, 'blog_create'])->name('blog.add');
    Route::post('/blog/submit', [BlogController::class, 'blog_submit'])->name('blog.submit');
    Route::get('/blog/manage', [BlogController::class, 'blog_manage'])->name('blog.manage');
    Route::get('/blog/update/{id}', [BlogController::class, 'blog_update'])->name('blog.update');
    Route::post('/blog/update/submit', [BlogController::class, 'blog_update_submit'])->name('blog.update.submit');
    Route::get('/blog/delete', [BlogController::class, 'blog_delete'])->name('blog.delete');



    // admin management
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');


    // image upload ck editor
    Route::post('image-upload', [DashboardController::class, 'storeImage'])->name('blog.image.upload');
});
