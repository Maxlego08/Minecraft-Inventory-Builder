<?php

use App\Http\Controllers\Admin\ButtonController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/')->name('admin.')->middleware(['auth', 'moderator', 'verified'])->group(function () {

// Moderator access
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');
// Route::get('/test', [ScrappingController::class, 'index2'])->name('test.scrapping');
// Route::get('/test2', [ScrappingController::class, 'renameFiles'])->name('test.rename');
// Route::get('/test3', [ScrappingController::class, 'updateDatabase'])->name('test.updatedatabase');
// Route::get('/test4', [ScrappingController::class, 'updateOtherValues'])->name('test.updateOtherValues');

    Route::prefix('resources/')->name('resources.')->group(function () {
        Route::get('/', [ResourceController::class, 'index'])->name('index');
        Route::get('/edit/{resource}', [ResourceController::class, 'show'])->name('edit');
        Route::get('/pending', [ResourceController::class, 'pending'])->name('pending');
        Route::post('/accept/{resource}', [ResourceController::class, 'accept'])->name('accept');
        Route::post('/refuse/{resource}', [ResourceController::class, 'refuse'])->name('refuse');
    });

    Route::prefix('logs/')->name('logs.')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('index');
    });

    Route::prefix('conversations/')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::post('/delete/{conversation}', [ConversationController::class, 'delete'])->middleware('admin')->name('delete');
    });

    Route::prefix('inventories/')->name('inventories.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::prefix('folders/')->name('folders.')->group(function () {
            Route::get('', [InventoryController::class, 'folders'])->name('index');
            Route::get('{folder}', [InventoryController::class, 'folderUser'])->name('user');
        });
    });

    Route::prefix('reports/')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/pending', [ReportController::class, 'pending'])->name('pending');
        Route::get('/{report}', [ReportController::class, 'view'])->name('view');
        Route::post('/resolve/{report}', [ReportController::class, 'resolve'])->name('resolve');
    });

// Admin access
    Route::middleware('admin')->group(function () {

        Route::get('/update/items', [ItemController::class, 'updateItems'])->name('update.items');
        Route::get('/update/json', [ItemController::class, 'updateJson'])->name('update.json');

        Route::prefix('users/')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::post('/{user}/store', [UserController::class, 'store'])->name('store');
            Route::post('/{user}/icon', [UserController::class, 'deleteIcon'])->name('delete.icon');
            Route::post('/{user}/banner', [UserController::class, 'deleteBanner'])->name('delete.banner');
            Route::post('/{user}/discord', [UserController::class, 'deleteDiscord'])->name('delete.discord');
            Route::post('/{user}/2fa', [UserController::class, 'deleteDoubleAuth'])->name('delete.2fa');
            Route::post('/{user}/payment', [UserController::class, 'updatePayment'])->name('payment');
        });

        Route::prefix('/payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/delete', [PaymentController::class, 'delete'])->name('delete');
            Route::get('/create', [PaymentController::class, 'create'])->name('create');
            Route::post('/store', [PaymentController::class, 'store'])->name('store');
            Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('show');
        });

        Route::prefix('/gift')->name('gift.')->group(function () {
            Route::get('/', [GiftController::class, 'index'])->name('index');
            Route::get('/delete/{gift}', [GiftController::class, 'delete'])->name('delete');
            Route::get('/create', [GiftController::class, 'create'])->name('create');
            Route::post('/store', [GiftController::class, 'store'])->name('store');
            Route::get('/edit/{gift}', [GiftController::class, 'edit'])->name('edit');
            Route::post('/update/{gift}', [GiftController::class, 'update'])->name('update');
        });

        Route::prefix('/buttons')->name('buttons.')->group(function () {
            Route::get('/', [ButtonController::class, 'index'])->name('index');
            Route::get('/{button}', [ButtonController::class, 'edit'])->name('edit');
            Route::post('/{button}/update', [ButtonController::class, 'update'])->name('update');
            Route::prefix('/content')->name('content.')->group(function () {
                Route::get('/{content}', [ButtonController::class, 'editContent'])->name('edit');
                Route::post('/update/{content}', [ButtonController::class, 'updateContent'])->name('update');
                Route::post('/destroy/{content}', [ButtonController::class, 'destroyContent'])->name('destroy');
                Route::get('/create/{button}', [ButtonController::class, 'createContent'])->name('create');
                Route::post('/store/{button}', [ButtonController::class, 'storeContent'])->name('store');
            });
        });
    });

    Route::prefix('videos')->name('videos.')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::post('/store', [VideoController::class, 'store'])->name('store');
        Route::get('/delete/{video}', [VideoController::class, 'delete'])->name('delete');
    });

});
