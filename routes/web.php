<?php

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

Route::get('/profil', function () {
    return view('auth.profil');
})->name('profil')->middleware('auth');

Route::prefix('resources')->name('resources.')->group(function () {

    Route::get('/')->name('index');
    Route::get('/create')->name('create');

});
