<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resource\ResourceAuthorController;
use App\Http\Controllers\Resource\ResourceBuyerController;
use App\Http\Controllers\Resource\ResourceCreateController;
use App\Http\Controllers\Resource\ResourceDownloadController;
use App\Http\Controllers\Resource\ResourceIndexController;
use App\Http\Controllers\Resource\ResourceReviewController;
use App\Http\Controllers\Resource\ResourceUpdateController;
use App\Http\Controllers\Resource\ResourceVersionController;
use App\Http\Controllers\Resource\ResourceViewController;
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
    Route::post('/command', [ProfileController::class, 'createCommand'])->name('command');
    Route::get('/alerts', [AlertController::class, 'show'])->name('alerts');
    Route::post('/alerts', [AlertController::class, 'latestAlerts'])->name('alert');
    Route::post('/messages', [AlertController::class, 'latestMessages'])->name('messages');

    // Conversation
    Route::prefix('/conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/create/{user}', [ConversationController::class, 'create'])->name('create');
        Route::post('/create/{user}', [ConversationController::class, 'store'])->name('store');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
        Route::post('/{conversation}/post', [ConversationController::class, 'post'])->name('post');
    });

    // Media
    Route::prefix('/images')->name('images.')->group(function () {
        Route::get('', [FileController::class, 'index'])->name('index');
        Route::post('store', [FileController::class, 'uploadImage'])->name('store');
        Route::post('store/redirect', [FileController::class, 'uploadImageForm'])->name('store.redirect');
        Route::post('delete/{file}', [FileController::class, 'delete'])->name('delete');
    });
});

Route::prefix('resources')->name('resources.')->group(function () {

    Route::get('/', [ResourceIndexController::class, 'index'])->name('index');

    Route::get('/authors/{slug}.{user}', [ResourceAuthorController::class, 'index'])->name('author');
    Route::get('/authors/{user}', [ResourceAuthorController::class, 'indexById'])->name('author.id');

    Route::middleware('auth')->group(function () {

        Route::prefix('create')->name('create.')->group(function () {
            Route::get('/', [ResourceCreateController::class, 'index'])->name('index');
            Route::post('/store', [ResourceCreateController::class, 'store'])->name('store');
        });

        Route::get('download/{resource}/{version}', [ResourceDownloadController::class, 'download'])->name('download');
        Route::post('review/{resource}', [ResourceReviewController::class, 'store'])->name('review.store');
        Route::post('review/{review}/delete', [ResourceReviewController::class, 'deleteReview'])->name('review.delete');
    });

    Route::get('/{slug}.{resource}/updates', [ResourceUpdateController::class, 'index'])->name('updates');
    Route::get('/{resource}/updates', [ResourceUpdateController::class, 'indexById'])->name('updates.id');

    Route::get('/{slug}.{resource}/reviews', [ResourceReviewController::class, 'index'])->name('reviews');
    Route::get('/{resource}/reviews', [ResourceReviewController::class, 'indexById'])->name('reviews.id');

    Route::get('/{slug}.{resource}/versions', [ResourceVersionController::class, 'index'])->name('versions');
    Route::get('/{resource}/versions', [ResourceVersionController::class, 'indexById'])->name('versions.id');

    Route::get('/{slug}.{resource}/buyers', [ResourceBuyerController::class, 'index'])->name('buyers');
    Route::get('/{resource}/buyers', [ResourceBuyerController::class, 'indexById'])->name('buyers.id');

    Route::get('/{slug}.{resource}', [ResourceViewController::class, 'index'])->name('view');
    Route::get('/{resource}', [ResourceViewController::class, 'indexById'])->name('view.id');

});
