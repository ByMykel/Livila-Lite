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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies');
    Route::post('/{id}/like', [LikeController::class, 'handleLike'])->name('movies.like');
    Route::get('/page/{page}', [MovieController::class, 'movies'])->name('movies.page');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/liked', [LikeController::class, 'index'])->name('liked');
    Route::get('/liked/page', [LikeController::class, 'movies'])->name('liked.page');
    Route::get('/watched', [WatchController::class, 'index'])->name('watched');
});
