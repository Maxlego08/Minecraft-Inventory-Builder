<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Moderator access
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::prefix('resources/')->name('resources.')->group(function () {
    Route::get('/', [ResourceController::class, 'index'])->name('index');
    Route::get('/pending', [ResourceController::class, 'pending'])->name('pending');
    Route::post('/accept/{resource}', [ResourceController::class, 'accept'])->name('accept');
    Route::post('/refuse/{resource}', [ResourceController::class, 'refuse'])->name('refuse');
});

// Admin access
Route::middleware('admin')->group(function () {

    Route::prefix('users/')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::post('/{user}/store', [UserController::class, 'store'])->name('store');
    });

    Route::prefix('logs/')->name('logs.')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('index');
    });
});
