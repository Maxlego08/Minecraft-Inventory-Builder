<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GiftController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ResourceUserController;
use App\Http\Controllers\Api\TooltipController;
use App\Http\Controllers\Api\V1\BStatsController;
use App\Http\Controllers\Api\V1\DiscordAuthController;
use App\Http\Controllers\Api\V1\DiscordController;
use App\Http\Controllers\Api\V1\InventoryController;
use App\Http\Controllers\Api\V1\PreviewController;
use App\Http\Controllers\Api\V1\ResourceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->name('v1.')->group(function () {

    Route::middleware(['auth:sanctum', 'abilities:' . env('ABILITY_RESOURCE')])->name('sanctum.')->group(function () {

        Route::get('/resources', [ResourceController::class, 'resources'])->name('resources');
        Route::get('/inventories', [InventoryController::class, 'inventories'])->name('inventories');
        Route::get('/inventory/{inventory}/download', [InventoryController::class, 'download'])->name('download');

    });

    Route::middleware('auth:sanctum')->post('auth/test', function () {
        return json_encode(['status' => true]);
    });

    Route::get('tooltip/{user}/test', [TooltipController::class, 'test'])->name('tooltip.test');

    // Allows you to create a token
    Route::post('/auth/login', [AuthController::class, "login"]);

    Route::get('/discord/authentication', [DiscordAuthController::class, 'authentication'])->name('discord');
    Route::get('/discord/user/{discordUserId}', [DiscordController::class, 'getUsingInformation'])->name('discord.user');
    Route::get('/discord/{server_id}', [DiscordController::class, 'getDiscordInformation'])->name('discord.information');
    Route::post('/preview', [PreviewController::class, 'preview'])->name('preview');

    Route::prefix('/resources')->name('resources.')->group(function () {
        Route::get('users', [ResourceUserController::class, 'find'])->name('user');
    });

    Route::prefix('/bstats')->name('bstats.')->group(function () {
        Route::get('/url/{id}', [BStatsController::class, 'getUrl'])->name('url');
        Route::get('/{id}/{chart}', [BStatsController::class, 'getStats'])->name('stats');
    });

    Route::post('{payment}/notification/{id?}', [PaymentController::class, 'notification'])->name('notification');
    Route::get('gift/verify/{code}/{contentType}/{contentId}/{user}', [GiftController::class, 'verify'])->name('gift');

    // Route::get('file/analyse', [FileController::class, 'index'])->name('file');
    // Route::post('file/analyse/store', [FileController::class, 'store'])->name('file.store');

});
