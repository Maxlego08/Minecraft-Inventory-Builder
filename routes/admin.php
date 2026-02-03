<?php

use App\Http\Controllers\Admin\ActionTypeController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\ButtonController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\HeadController;
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

// Moderator access
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');

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

    Route::prefix('files/')->name('files.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');
        Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
        Route::post('/clear-cache', [FileController::class, 'clearCache'])->name('clear-cache');
    });

    Route::prefix('heads/')->name('heads.')->group(function () {
        Route::get('/', [HeadController::class, 'index'])->name('index');
        Route::post('/download', [HeadController::class, 'downloadCategories'])->name('download');
        Route::post('/categorize', [HeadController::class, 'categorizeHeads'])->name('categorize');
        Route::post('/scrape', [HeadController::class, 'scrapeHeads'])->name('scrape');
    });

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

    Route::prefix('/addons')->name('addons.')->group(function () {
        Route::get('/', [AddonController::class, 'index'])->name('index');
        Route::get('/create', [AddonController::class, 'create'])->name('create');
        Route::post('/store', [AddonController::class, 'store'])->name('store');
        Route::get('/{addon}', [AddonController::class, 'edit'])->name('edit');
        Route::post('/{addon}/update', [AddonController::class, 'update'])->name('update');
    });

    Route::prefix('/actions')->name('actions.')->group(function () {
        Route::get('/', [ActionTypeController::class, 'index'])->name('index');
        Route::get('/create', [ActionTypeController::class, 'create'])->name('create');
        Route::post('/store', [ActionTypeController::class, 'store'])->name('store');
        Route::get('/{action}', [ActionTypeController::class, 'edit'])->name('edit');
        Route::post('/{action}/update', [ActionTypeController::class, 'update'])->name('update');
        Route::prefix('/content')->name('content.')->group(function () {
            Route::get('/{content}', [ActionTypeController::class, 'editContent'])->name('edit');
            Route::post('/update/{content}', [ActionTypeController::class, 'updateContent'])->name('update');
            Route::post('/destroy/{content}', [ActionTypeController::class, 'destroyContent'])->name('destroy');
            Route::get('/create/{action}', [ActionTypeController::class, 'createContent'])->name('create');
            Route::post('/store/{action}', [ActionTypeController::class, 'storeContent'])->name('store');
        });
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
