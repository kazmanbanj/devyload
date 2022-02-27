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
    Route::get('/threads/create', [App\Http\Controllers\ThreadController::class, 'create'])->name('threads.create');
    Route::get('/threads', [App\Http\Controllers\ThreadController::class, 'index'])->name('threads');
    Route::get('/threads/{channel}', [App\Http\Controllers\ThreadController::class, 'index'])->name('channels');
    Route::get('/threads/{channelId}/{thread}', [App\Http\Controllers\ThreadController::class, 'show'])->name('threads.show');
    Route::post('/threads', [App\Http\Controllers\ThreadController::class, 'store'])->name('threads.store');


    Route::post('/threads/{channelId}/{threadId}/replies', [App\Http\Controllers\RepliesController::class, 'store'])->name('replies.store');
});