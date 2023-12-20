<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resource\DashboardController;
use App\Http\Controllers\Resource\DashboardDiscordController;
use App\Http\Controllers\Resource\DashboardGiftController;
use App\Http\Controllers\Resource\ResourceAuthorController;
use App\Http\Controllers\Resource\ResourceBuyerController;
use App\Http\Controllers\Resource\ResourceCreateController;
use App\Http\Controllers\Resource\ResourceDownloadController;
use App\Http\Controllers\Resource\ResourceEditController;
use App\Http\Controllers\Resource\ResourceIconController;
use App\Http\Controllers\Resource\ResourceIndexController;
use App\Http\Controllers\Resource\ResourcePurchaseController;
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

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::prefix('/profile')->name('profile.')->middleware('auth')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::prefix('/picture')->name('picture.')->group(function () {
        Route::post('/destroy', [ProfileController::class, 'destroyProfile'])->name('destroy');
        Route::post('/update', [ProfileController::class, 'uploadProfile'])->name('update');
    });
    Route::prefix('/banner')->name('banner.')->group(function () {
        Route::post('/destroy', [ProfileController::class, 'destroyProfileBanner'])->name('destroy');
        Route::post('/update', [ProfileController::class, 'uploadProfileBanner'])->name('update');
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

    // Payment
    Route::prefix('/payment')->name('payment.')->group(function () {
        Route::get('', [PaymentController::class, 'index'])->name('index');
        Route::post('/store/stripe', [PaymentController::class, 'storeStripe'])->name('store.stripe');
        Route::post('/store/paypal', [PaymentController::class, 'storePaypal'])->name('store.paypal');
        Route::post('/store/currency', [PaymentController::class, 'storeCurrency'])->name('store.currency');
        Route::post('/delete/stripe', [PaymentController::class, 'deleteStripe'])->name('delete.stripe');
        Route::post('/delete/paypal', [PaymentController::class, 'deletePaypal'])->name('delete.paypal');
    });

    // Colors
    Route::prefix('/colors')->name('colors.')->group(function () {
        Route::get('', [NameController::class, 'index'])->name('index');
        Route::post('/checkout/{nameColor}', [NameController::class, 'checkout'])->name('checkout');
        Route::post('/purchase/{nameColor}', [NameController::class, 'purchase'])->name('purchase');
        Route::post('/disable', [NameController::class, 'disable'])->name('disable');
        Route::post('/enable/{nameColor}', [NameController::class, 'active'])->name('store');
    });
});

Route::prefix('resources')->name('resources.')->group(function () {

    Route::get('/', [ResourceIndexController::class, 'index'])->name('index');

    Route::get('/authors/{slug}.{user}', [ResourceAuthorController::class, 'index'])->name('author');
    Route::get('/authors/{user}', [ResourceAuthorController::class, 'indexById'])->name('author.id');

    Route::get('/payment/success/{payment:payment_id}', [ResourcePurchaseController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{payment:payment_id}', [ResourcePurchaseController::class, 'cancel'])->name('payment.cancel');

    Route::middleware('auth')->group(function () {

        // Create
        Route::prefix('create')->name('create.')->group(function () {
            Route::get('/', [ResourceCreateController::class, 'index'])->name('index');
            Route::post('/store', [ResourceCreateController::class, 'store'])->name('store');
        });

        // Edit
        Route::prefix('edit/{resource}')->name('edit.')->group(function () {
            Route::get('/', [ResourceEditController::class, 'index'])->name('index');
            Route::post('/store', [ResourceEditController::class, 'store'])->name('store');
        });

        // Download
        Route::get('download/{resource}/{version}', [ResourceDownloadController::class, 'download'])->name('download');

        Route::get('purchased', [ResourcePurchaseController::class, 'purchased'])->name('purchased');

        // Review
        Route::prefix('review/')->name('review.')->group(function () {
            Route::post('{resource}', [ResourceReviewController::class, 'store'])->name('store');
            Route::post('{review}/delete', [ResourceReviewController::class, 'deleteReview'])->name('delete');
            Route::post('{review}/reply', [ResourceReviewController::class, 'reply'])->name('reply');
            Route::post('{review}/reply/delete', [ResourceReviewController::class, 'deleteResponse'])->name('response');
        });

        // Buyers
        Route::get('/{slug}.{resource}/buyers', [ResourceBuyerController::class, 'index'])->name('buyers');
        Route::get('/{resource}/buyer/remove/{buyer}', [ResourceBuyerController::class, 'remove'])->name('buyers.remove');
        Route::post('/{resource}/buyer/create', [ResourceBuyerController::class, 'create'])->name('buyers.create');
        Route::get('/{resource}/buyers', [ResourceBuyerController::class, 'indexById'])->name('buyers.id');

        // Update
        Route::prefix('/{resource}/update')->name('update.')->group(function () {
            Route::get('/', [ResourceUpdateController::class, 'update'])->name('index');
            Route::post('/store', [ResourceVersionController::class, 'store'])->name('store');
        });

        // icon
        Route::post('/{resource}/icon', [ResourceIconController::class, 'store'])->name('icon');

        Route::get('/{resource}/purchase', [ResourcePurchaseController::class, 'index'])->name('purchase');
        Route::post('/{resource}/purchase/create/session', [ResourcePurchaseController::class, 'store'])->name('purchase.session');

        Route::prefix('/dashboard/')->name('dashboard.')->group(function () {
            Route::get('', [DashboardController::class, 'index'])->name('index');
            Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
            Route::get('/payments/{payment:payment_id}', [DashboardController::class, 'paymentDetails'])->name('payments.details');
            Route::get('/resources', [DashboardController::class, 'resources'])->name('resources');

            Route::prefix('/gift/')->name('gift.')->group(function () {
                Route::get('', [DashboardGiftController::class, 'index'])->name('index');

            });

            Route::prefix('/discord/')->name('discord.')->group(function () {
                Route::get('', [DashboardDiscordController::class, 'index'])->name('index');
                Route::get('/create', [DashboardDiscordController::class, 'create'])->name('create');
                Route::post('/store', [DashboardDiscordController::class, 'store'])->name('store');
                Route::post('/delete/{notification}', [DashboardDiscordController::class, 'delete'])->name('delete');
                Route::get('/edit/{notification}', [DashboardDiscordController::class, 'edit'])->name('edit');
                Route::post('/store/{notification}', [DashboardDiscordController::class, 'update'])->name('update');
            });

        });
    });

    Route::get('/{slug}.{resource}/updates', [ResourceUpdateController::class, 'index'])->name('updates');
    Route::get('/{resource}/updates', [ResourceUpdateController::class, 'indexById'])->name('updates.id');

    Route::get('/{slug}.{resource}/reviews', [ResourceReviewController::class, 'index'])->name('reviews');
    Route::get('/{resource}/reviews', [ResourceReviewController::class, 'indexById'])->name('reviews.id');

    Route::get('/{slug}.{resource}/versions', [ResourceVersionController::class, 'index'])->name('versions');
    Route::get('/{resource}/versions', [ResourceVersionController::class, 'indexById'])->name('versions.id');

    Route::get('/{slug}.{resource}', [ResourceViewController::class, 'index'])->name('view');
    Route::get('/{resource}', [ResourceViewController::class, 'indexById'])->name('view.id');

});
