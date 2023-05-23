<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');


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
