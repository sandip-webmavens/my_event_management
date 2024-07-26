<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AttendeeController;
use App\Http\Controllers\admin\BookmarkController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\TicketController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\user\AttendeeUserController;
use App\Http\Controllers\user\BookmarkUserController;
use App\Http\Controllers\user\TicketUserController;
use App\Http\Controllers\user\UserAreaController;
use App\Http\Controllers\admin\OrganizationController;
use App\Http\Controllers\user\UserEventController;
use App\Http\Controllers\UserloginController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserSession;

// Admin Routes
Route::get('/', [AdminController::class, 'AdminPenal'])->name('admin')->middleware(CheckUserSession::class);

Route::prefix('admin')->middleware(CheckUserSession::class)->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('', [UserController::class, 'UserShow'])->name('user.show');
        Route::get('/create', [UserController::class, 'UserCreate'])->name('user.create');
        Route::post('/store', [UserController::class, 'UserStore'])->name('user.store');
        Route::get('/view/{id}', [UserController::class, 'UserView'])->name('user.view');
        Route::get('/edit/{id}', [UserController::class, 'UserEdit'])->name('user.edit');
        Route::post('/edit/{id}', [UserController::class, 'UserEditStore'])->name('user.edit.store');
        Route::get('/delete/{id}', [UserController::class, 'UserDelete'])->name('user.delete');
        Route::get('/logout', [UserController::class, 'logout'])->name('admin.user.logout');
    });
    Route::resource('/organization', OrganizationController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/event', EventController::class);
    Route::resource('/ticket', TicketController::class);
    Route::resource('/bookmark', BookmarkController::class);

    Route::get('/attendee', [AttendeeController::class, 'index'])->name('attendee.index');
    Route::get('/attendee/{id}/ticket', [AttendeeController::class, 'EventTickets'])->name('attendee.show.ticket');
    Route::post('/attendee/store', [AttendeeController::class, 'store'])->name('attendee.store');

});

// User Routes
Route::prefix('/user')->group(function () {
    Route::get('/register', [UserloginController::class, 'index'])->name('user.register');
    Route::post('/register', [UserloginController::class, 'register'])->name('user.register.post');
    Route::get('/login', [UserloginController::class, 'userLogin'])->name('user.login');
    Route::post('/login', [UserloginController::class, 'userLoginPost'])->name('user.login.post');
    Route::post('/logout', [UserloginController::class, 'logout'])->name('user.logout');

    Route::resource('/event', UserEventController::class)->names([
        'index' => 'user.event.index',
        'create' => 'user.event.create',
        'store' => 'user.event.store',
        'show' => 'user.event.show',
        'edit' => 'user.event.edit',
        'update' => 'user.event.update',
        'destroy' => 'user.event.destroy'
    ]);
    Route::resource('/ticket', TicketUserController::class)->names([
        'index' => 'user.ticket.index',
        'create' => 'user.ticket.create',
        'store' => 'user.ticket.store',
        'show' => 'user.ticket.show',
        'edit' => 'user.ticket.edit',
        'update' => 'user.ticket.update',
        'destroy' => 'user.ticket.destroy'
    ]);
    Route::resource('/bookmark', BookmarkUserController::class)->names([
        'index' => 'user.bookmark.index',
        'create' => 'user.bookmark.create',
        'store' => 'user.bookmark.store',
        'show' => 'user.bookmark.show',
        'edit' => 'user.bookmark.edit',
        'update' => 'user.bookmark.update',
        'destroy' => 'user.bookmark.destroy'
    ]);

    Route::get('/attendee', [AttendeeUserController::class, 'index'])->name('user.attendee.index');
    Route::get('/attendee/{id}/ticket', [AttendeeUserController::class, 'EventTickets'])->name('user.attendee.show.ticket');
    Route::post('/attendee/store', [AttendeeUserController::class, 'store'])->name('user.attendee.store');
});

Route::resource('/home', UserAreaController::class)->middleware(CheckUserSession::class);

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/auth/linkedin', [SocialiteController::class, 'redirectToLinkedin'])->name('auth.linkedin');
Route::get('/auth/linkedin/callback', [SocialiteController::class, 'handleLinkedinCallback']);

Route::get('/auth/twitter', [SocialiteController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('/auth/twitter/callback', [SocialiteController::class, 'handleTwitterCallback']);
