<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::get('/threads/create', [App\Http\Controllers\ThreadsController::class, 'create'])->name('threads.create');
    Route::get('/threads', [App\Http\Controllers\ThreadsController::class, 'index'])->name('threads');
    Route::get('/threads/{channel}', [App\Http\Controllers\ThreadsController::class, 'index'])->name('channels');
    Route::get('/threads/{channelId}/{thread}', [App\Http\Controllers\ThreadsController::class, 'show'])->name('threads.show');
    Route::delete('/threads/{channelId}/{thread}', [App\Http\Controllers\ThreadsController::class, 'destroy'])->name('threads.destroy');
    Route::post('/threads', [App\Http\Controllers\ThreadsController::class, 'store'])->name('threads.store');


    Route::post('/threads/{channelId}/{threadId}/replies', [App\Http\Controllers\RepliesController::class, 'store'])->name('replies.store');
    Route::delete('/replies/{reply}', [App\Http\Controllers\RepliesController::class, 'destroy'])->name('reply.delete');


    Route::post('replies/{reply}/favorites', [App\Http\Controllers\FavoritesController::class, 'store'])->name('favorites');


    Route::get('profiles/{user}', [App\Http\Controllers\ProfilesController::class, 'show'])->name('profile.show');
});