<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\WatchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [MovieController::class, 'index'])->name('movies');

Route::prefix('movies')->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::post('/{id}/like', [LikeController::class, 'handleLike'])->name('movies.like');
        Route::post('/{id}/watch', [WatchController::class, 'handleWatch'])->name('movies.watch');
    });

    Route::get('/page/{page}', [MovieController::class, 'movies'])->name('movies.page');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('liked')->group(function () {
        Route::get('/', [LikeController::class, 'index'])->name('liked');
        Route::get('/page', [LikeController::class, 'movies'])->name('liked.page');
    });

    Route::prefix('watched')->group(function () {
        Route::get('/', [WatchController::class, 'index'])->name('watched');
        Route::get('/page', [WatchController::class, 'movies'])->name('watched.page');
    });
});
