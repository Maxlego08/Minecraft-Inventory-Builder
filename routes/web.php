<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\Api\TooltipController;
use App\Http\Controllers\Builder\BuilderDownloadController;
use App\Http\Controllers\Builder\BuilderHeadController;
use App\Http\Controllers\Builder\BuilderIndexController;
use App\Http\Controllers\Builder\BuilderInventoryController;
use App\Http\Controllers\Builder\BuilderInventoryVisibilityController;
use App\Http\Controllers\Builder\BuilderItemsController;
use App\Http\Controllers\Builder\BuilderMarketplaceController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NameChangeController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
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
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

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

Route::get('storage/images/preview/{file:file_name}.png', [FileController::class, 'preview'])->name('image.preview');
Route::get('/tooltip/{user}', [TooltipController::class, 'tooltip'])->name('tooltip');

Route::prefix('/account-upgrade')->name('premium.')->group(function () {
    Route::get('/', [PremiumController::class, 'index'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::get('/checkout/{userRole:power}', [PremiumController::class, 'checkout'])->name('checkout');
        Route::post('/purchase/{userRole:power}', [PremiumController::class, 'purchase'])->name('purchase');
    });
});

Route::get('/inventories/download/{inventory}', [BuilderDownloadController::class, 'downloadPublic'])->name('inventory.download');

Route::prefix('/builder')->name('builder.')->middleware('auth')->group(function () {

    Route::get('/', [BuilderIndexController::class, 'index'])->name('index');
    Route::get('/inventories', [BuilderMarketplaceController::class, 'inventories'])->name('inventories');
    Route::get('/inventory/{inventory}', [BuilderInventoryController::class, 'edit'])->name('edit');
    // Route::get('/test', [BuilderIndexController::class, 'test'])->name('test');

    Route::prefix('/api')->name('api.')->middleware('auth')->group(function () {
        Route::prefix('/folders')->name('folder.')->group(function () {
            Route::get('/{folder?}', [BuilderIndexController::class, 'folders'])->name('get');
            Route::post('/{folder}/delete', [BuilderIndexController::class, 'delete'])->name('delete');
            Route::post('/create/{folderParent}', [BuilderIndexController::class, 'create'])->name('create');
            Route::post('/update/{folder}', [BuilderIndexController::class, 'update'])->name('update');
        });
        Route::prefix('/inventories')->name('inventories.')->group(function () {
            Route::get('/{folder}', [BuilderInventoryController::class, 'inventories'])->name('get');
            Route::post('/{folder}/create', [BuilderInventoryController::class, 'create'])->name('create');
            Route::post('/{inventory}/update', [BuilderInventoryController::class, 'update'])->name('update');
            Route::get('/{inventory}/download', [BuilderDownloadController::class, 'download'])->name('download');
            Route::post('/{inventory}/rename', [BuilderInventoryController::class, 'rename'])->name('rename');
            Route::post('/{inventory}/delete', [BuilderInventoryController::class, 'delete'])->name('delete');
            Route::post('/{inventory}/copy', [BuilderInventoryController::class, 'copy'])->name('copy');
            Route::post('/{inventory}/visibility/{inventoryVisibility}', [BuilderInventoryVisibilityController::class, 'changeVisibility'])->name('visibility');
        });
        Route::prefix('/items')->name('items.')->group(function () {
            Route::get('/all', [BuilderItemsController::class, 'items'])->name('all');
        });
        Route::get('/heads/{search}', [BuilderHeadController::class, 'search'])->name('search');
    });
});

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
        Route::post('/toggle', [ConversationController::class, 'toggle'])->name('toggle');
        Route::post('/create/{user}', [ConversationController::class, 'store'])->name('store');
        Route::post('/auto/response}', [ConversationController::class, 'autoResponse'])->name('auto');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
        Route::post('/{conversation}/post', [ConversationController::class, 'post'])->name('post');
    });

    // Media
    Route::prefix('/images')->name('images.')->group(function () {
        Route::get('', [FileController::class, 'index'])->name('index');
        Route::post('store', [FileController::class, 'uploadImage'])->name('store');
        Route::post('store/redirect', [FileController::class, 'uploadImageForm'])->name('store.redirect');
        Route::post('delete/multiple', [FileController::class, 'deleteAll'])->name('delete.all');
        Route::post('delete/single/{file}', [FileController::class, 'delete'])->name('delete');
    });

    // Payment
    Route::prefix('/payment')->name('payment.')->middleware('verified')->group(function () {
        Route::get('', [PaymentController::class, 'index'])->name('index');
        Route::post('/store/stripe', [PaymentController::class, 'storeStripe'])->name('store.stripe');
        Route::post('/store/paypal', [PaymentController::class, 'storePaypal'])->name('store.paypal');
        Route::post('/store/currency', [PaymentController::class, 'storeCurrency'])->name('store.currency');
        Route::post('/delete/stripe', [PaymentController::class, 'deleteStripe'])->name('delete.stripe');
        Route::post('/delete/paypal', [PaymentController::class, 'deletePaypal'])->name('delete.paypal');
    });

    // Colors
    Route::prefix('/colors')->name('colors.')->middleware('verified')->group(function () {
        Route::get('', [NameController::class, 'index'])->name('index');
        Route::post('/checkout/{nameColor}', [NameController::class, 'checkout'])->name('checkout');
        Route::post('/purchase/{nameColor}', [NameController::class, 'purchase'])->name('purchase');
        Route::post('/disable', [NameController::class, 'disable'])->name('disable');
        Route::post('/enable/{nameColor}', [NameController::class, 'active'])->name('store');
    });


    // Colors
    Route::prefix('/update-name')->name('name.')->middleware('verified')->group(function () {
        Route::get('', [NameChangeController::class, 'index'])->name('index');
        Route::post('', [NameChangeController::class, 'updateName'])->name('store');
    });

    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
});

Route::prefix('resources')->name('resources.')->group(function () {

    Route::get('/', [ResourceIndexController::class, 'index'])->name('index');

    Route::get('/authors/{slug}.{user}', [ResourceAuthorController::class, 'index'])->name('author');
    Route::get('/authors/{user}', [ResourceAuthorController::class, 'indexById'])->name('author.id');

    Route::get('/payment/success/{payment:payment_id}', [ResourcePurchaseController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{payment:payment_id}', [ResourcePurchaseController::class, 'cancel'])->name('payment.cancel');

    Route::middleware('auth')->group(function () {

        // Create
        Route::prefix('create')->middleware('verified')->name('create.')->group(function () {
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
        Route::get('purchased/{payment:payment_id}', [ResourcePurchaseController::class, 'paymentDetails'])->name('purchased.payment');

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

        Route::middleware('verified')->group(function () {

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
                    Route::post('/test/{notification}', [DashboardDiscordController::class, 'test'])->name('test');
                    Route::get('/edit/{notification}', [DashboardDiscordController::class, 'edit'])->name('edit');
                    Route::post('/store/{notification}', [DashboardDiscordController::class, 'update'])->name('update');
                });

            });
        });
    });

    Route::get('/{slug}.{resource}/updates', [ResourceUpdateController::class, 'index'])->name('updates');
    Route::get('/{resource}/updates', [ResourceUpdateController::class, 'indexById'])->name('updates.id');

    Route::get('/{slug}.{resource}/updates/{version}', [ResourceUpdateController::class, 'indexUpdate'])->name('update');
    Route::get('/update/{version}', [ResourceUpdateController::class, 'indexUpdateById'])->name('update.id');

    Route::get('/{slug}.{resource}/reviews', [ResourceReviewController::class, 'index'])->name('reviews');
    Route::get('/{resource}/reviews', [ResourceReviewController::class, 'indexById'])->name('reviews.id');

    Route::get('/{slug}.{resource}/versions', [ResourceVersionController::class, 'index'])->name('versions');
    Route::get('/{resource}/versions', [ResourceVersionController::class, 'indexById'])->name('versions.id');

    Route::get('/{slug}.{resource}', [ResourceViewController::class, 'index'])->name('view');
    Route::get('/{resource}', [ResourceViewController::class, 'indexById'])->name('view.id');

});


Route::middleware('auth')->group(function () {

    Route::prefix('like')->name('like.')->group(function () {
        Route::post('/resource/{resource}', [LikeController::class, 'toggleResourceLike'])->name('resource');
        Route::post('/version/{version}', [LikeController::class, 'toggleVersionLike'])->name('version');
    });

    Route::prefix('report')->name('report.')->group(function () {
        Route::post('/resource/{resource}', [ReportController::class, 'reportResource'])->name('resource');
        Route::post('/version/{version}', [ReportController::class, 'reportVersion'])->name('version');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('export/data/to/json', [ExportDataController::class, 'index'])->name('export.data.json');
});

Route::prefix('subscribe')->name('subscribe.')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
});


//Newsletter
Route::middleware(['auth'])->group(function () {
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::post('/newsletter/active', [NewsletterController::class, 'newsletterActive'])->name('newsletter.active');
    Route::post('/newsletter/inactive', [NewsletterController::class, 'newsletterInactive'])->name('newsletter.inactive');
});
