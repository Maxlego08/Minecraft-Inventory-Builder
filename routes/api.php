<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\DiscordAuthController;
use App\Http\Controllers\Api\V1\PreviewController;
use Illuminate\Http\Request;
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
    Route::middleware(['auth:sanctum', 'abilities:' . env('ABILITY_RESOURCE')])->get('/user', function (Request $request) {
        return $request->user();
    });

    // Permet de créer un token
    Route::post('/auth/login', [AuthController::class, "login"]);
    Route::get('/discord/authentication', [DiscordAuthController::class, 'authentication'])->name('discord');
    Route::post('/preview', [PreviewController::class, 'preview'])->name('preview');

});
