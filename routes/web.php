<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\UserAvatarController;
use App\Http\Controllers\UserNotificationsController;
use App\Http\Controllers\Auth\RegisterConfirmationController;
use Whoops\Run;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('log-viewer')->middleware('feature:log-viewer');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // ->middleware('feature:new-thread');


    Route::get('/threads/create', [App\Http\Controllers\ThreadsController::class, 'create'])->name('threads.create');
    Route::get('/threads', [App\Http\Controllers\ThreadsController::class, 'index'])->name('threads');
    Route::get('/threads/{channel}', [App\Http\Controllers\ThreadsController::class, 'index'])->name('channels');
    Route::get('/threads/{channel}/{thread}', [App\Http\Controllers\ThreadsController::class, 'show'])->name('threads.show');
    Route::patch('/threads/{channel}/{thread}', [App\Http\Controllers\ThreadsController::class, 'update'])->name('threads.update');
    Route::patch('/threads/{channel}/{thread}', [App\Http\Controllers\ThreadsController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{channel}/{thread}', [App\Http\Controllers\ThreadsController::class, 'destroy'])->name('threads.destroy');
    Route::post('/threads', [App\Http\Controllers\ThreadsController::class, 'store'])->name('threads.store')->middleware('must-be-confirmed');


    Route::post('locked-threads/{thread}', [App\Http\Controllers\LockedThreadsController::class, 'store'])->name('locked-threads.store')->middleware('admin');
    Route::delete('locked-threads/{thread}', [App\Http\Controllers\LockedThreadsController::class, 'destroy'])->name('locked-threads.destroy')->middleware('admin');


    Route::post('/threads/{channel}/{thread}/subscriptions', [App\Http\Controllers\ThreadSubscriptionsController::class, 'store'])->name('thread.subscriptions.store');
    Route::delete('/threads/{channel}/{thread}/subscriptions', [App\Http\Controllers\ThreadSubscriptionsController::class, 'destroy'])->name('thread.subscriptions.destroy');


    Route::get('/threads/{channel}/{thread}/replies', [App\Http\Controllers\RepliesController::class, 'index'])->name('replies.index');
    Route::post('/threads/{channel}/{thread}/replies', [App\Http\Controllers\RepliesController::class, 'store'])->name('replies.store');
    Route::patch('/replies/{reply}', [App\Http\Controllers\RepliesController::class, 'update'])->name('reply.update');
    Route::delete('/replies/{reply}', [App\Http\Controllers\RepliesController::class, 'destroy'])->name('reply.delete');


    Route::post('/replies/{reply}/best', [App\Http\Controllers\BestRepliesController::class, 'store'])->name('best-replies.delete');


    Route::post('replies/{reply}/favorites', [App\Http\Controllers\FavoritesController::class, 'store'])->name('favorites.store');
    Route::delete('replies/{reply}/favorites', [App\Http\Controllers\FavoritesController::class, 'destroy'])->name('favorites.delete');


    Route::get('profiles/{user}', [App\Http\Controllers\ProfilesController::class, 'show'])->name('profile.show');


    Route::get('profiles/{user}/notifications', [UserNotificationsController::class, 'index']);
    Route::delete('profiles/{user}/notifications/{notification}', [UserNotificationsController::class, 'destroy']);

    Route::get('register/confirm', [RegisterConfirmationController::class, 'index'])->name('register.confirm');

    Route::get('api/users', [UsersController::class, 'index']);
    Route::post('api/users/{user}/avatar', [UserAvatarController::class, 'store'])->name('avatar');
});
