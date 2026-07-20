<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\PostController;

Route::prefix('admin')->middleware('admin')->group(function () {

    // ===============================
    // Dashboard
    // ===============================
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
    });

    // ===============================
    // Account
    // ===============================
    Route::prefix('account')->controller(AccountController::class)->group(function () {
        Route::get('/', 'index')->name('account.index');
        Route::get('/edit', 'edit')->name('account.edit');
        Route::post('/update', 'update')->name('account.update');
    });

    // ===============================
    // Contact
    // ===============================
    Route::prefix('contact')->controller(ContactController::class)->group(function () {
        Route::get('/', 'index')->name('contact.index');
    });

    // ===============================
    // Messages
    // ===============================
    Route::prefix('messages')->controller(MessageController::class)->group(function () {
        Route::get('/', 'index')->name('messages.index');
        Route::put('/{message_id}', 'update')->name('messages.update');
        Route::delete('/{message_id}', 'destroy')->name('messages.destroy');
    });

    // ===============================
    // Posts
    // ===============================
    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('posts.index');
        Route::put('/{post}', 'update')->name('posts.update');
        Route::delete('/{post}', 'destroy')->name('posts.destroy');
    });

    // ===============================
    // End of admin routes
    // ===============================
});