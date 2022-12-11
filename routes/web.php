<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProfileController;
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
    return view('home');
})->name('home');

Route::prefix('/profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::prefix('/picture')->name('picture.')->group(function () {
        Route::post('/destroy', [ProfileController::class, 'destroyProfile'])->name('destroy');
        Route::post('/update', [ProfileController::class, 'uploadProfile'])->name('update');
    });
    Route::post('/email', [ProfileController::class, 'changeEmail'])->name('email');
    Route::post('/password', [ProfileController::class, 'changePassword'])->name('password');
    Route::post('/discord', [ProfileController::class, 'discord'])->name('discord');
    Route::post('/2fa/code', [ProfileController::class, 'downloadRecoveryCode'])->name('2fa');
    Route::get('/alerts', [AlertController::class, 'show'])->name('alerts');
    Route::post('/alerts', [AlertController::class, 'latestAlerts'])->name('alert');

    Route::prefix('/conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
    });
});

Route::prefix('resources')->name('resources.')->group(function () {

    Route::get('/')->name('index');
    Route::get('/create')->name('create');
    Route::get('/authors/{user}')->name('author');

});
