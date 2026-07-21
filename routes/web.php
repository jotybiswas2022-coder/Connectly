<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\MessageController;
use App\Http\Controllers\user\FeedController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\FriendRequestController;
use App\Http\Controllers\user\NotificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\SiteController;

// Site home and contact page routes
Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/contact', 'contact')->name('contact.page');
});

// Legal pages
Route::view('/privacy', 'frontend.legal.privacy')->name('privacy');
Route::view('/terms', 'frontend.legal.terms')->name('terms');
Route::view('/cookies', 'frontend.legal.cookies')->name('cookies');
Route::view('/gdpr', 'frontend.legal.gdpr')->name('gdpr');

// Contact form submission route
Route::post('/contact', [UserController::class, 'contact'])->name('contact');

// Password reset link request form route
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Protected route to serve media files
Route::middleware('auth')->get('/media/{path}', [MessageController::class, 'media'])
    ->where('path', '.*')
    ->name('media.show');

// Feed route
Route::middleware('auth')->prefix('/feed')->controller(FeedController::class)->group(function () {
    Route::get('/', 'feed')->name('feed');
    Route::post('/posts', 'storePost')->name('feed.posts.store');
    Route::get('/posts/{post}/edit', 'editPost')->name('feed.posts.edit');
    Route::get('/posts/{post}/comments', 'showComments')->name('feed.posts.comments');
    Route::put('/posts/{post}', 'updatePost')->name('feed.posts.update');
    Route::delete('/posts/{post}', 'deletePost')->name('feed.posts.delete');
    Route::post('/posts/{post}/react', 'toggleReaction')->name('feed.posts.react');
    Route::get('/posts/{post}/reactors', 'getReactors')->name('feed.posts.reactors');
    Route::post('/posts/{post}/comments', 'storeComment')->name('feed.posts.comments.store');
    Route::post('/comments/{comment}/react', 'toggleCommentReaction')->name('feed.comments.react');
});

// User profile routes
Route::middleware('auth')->prefix('/{user_id}/profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'showProfile')->name('profile.show');
    Route::get('/settings', 'showSettings')->name('profile.settings');
    Route::put('/update', 'updateProfile')->name('profile.update');
    Route::put('/posts/{post}/pin', 'togglePinPost')->name('profile.posts.pin');
});

// Friend request routes
Route::middleware('auth')->prefix('/friend-request')->controller(FriendRequestController::class)->group(function () {
    Route::post('/{receiver_id}/send', 'send')->name('friend-request.send');
    Route::put('/{request_id}/accept', 'accept')->name('friend-request.accept');
    Route::put('/{request_id}/reject', 'reject')->name('friend-request.reject');
    Route::delete('/{request_id}/cancel', 'cancel')->name('friend-request.cancel');
    Route::delete('/{user_id}/unfriend', 'unfriend')->name('friend-request.unfriend');
});

// Notification routes
Route::middleware('auth')->prefix('/notifications')->controller(NotificationController::class)->group(function () {
    Route::get('/fetch', 'fetch')->name('notifications.fetch');
    Route::get('/stream', 'stream')->name('notifications.stream');
    Route::post('/{id}/read', 'markAsRead')->name('notifications.read');
    Route::post('/mark-all-read', 'markAllRead')->name('notifications.mark-all-read');
});

// Friends page
Route::middleware('auth')->get('/friends', [FriendRequestController::class, 'friends'])->name('friends');

// Message-related routes
Route::middleware('auth')->prefix('/{user_id}/message')->controller(MessageController::class)->group(function () {
    Route::get('/', 'message')->name('message');
    Route::get('/fetch', 'fetchMessages')->name('message.fetch');
    Route::post('/send', 'sendMessage')->name('message.send');
    Route::put('/{message_id}/update', 'updateMessage')->name('message.update');
    Route::delete('/{message_id}/delete', 'deleteMessage')->name('message.destroy');
    Route::delete('/{message_id}/delete-for-me', 'deleteMessageForMe')->name('message.delete-for-me');
});

// User search route
Route::get('/search-users', [App\Http\Controllers\user\UserController::class, 'user_search'])->name('users.search');
Route::get('/search', [App\Http\Controllers\user\UserController::class, 'search'])->name('search');


// Authentication routes
Auth::routes();

// Include admin route file
include('admin.php');
