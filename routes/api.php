<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\SiteController;
use App\Http\Controllers\api\v1\TagController;
use App\Http\Controllers\api\v1\SubscriberController;
use App\Http\Controllers\api\v1\PostController;

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


Route::prefix('v1')->group(function () {

    // Routes for sites.
    Route::prefix('site')->group(function () {
        Route::post('register', [SiteController::class, 'store']);
        Route::get('all', [SiteController::class, 'index']);
        Route::get('get/{id}', [SiteController::class, 'show']);

        //Route::patch('update', '');
        //Route::delete('delete/{id}', '');
    });

    // Routes for Tags.
    Route::prefix('tag')->group(function () {
        Route::post('add', [TagController::class, 'store']);
        Route::get('all', [TagController::class, 'index']);
        Route::get('get/{id}', [TagController::class, 'show']);

        //Route::patch('update', '');
        //Route::delete('delete/{id}', '');
    });

    // Routes for Subscribers.
    Route::prefix('subscriber')->group(function () {
        Route::post('subscribe', [SubscriberController::class, 'store']);
        Route::get('all', [SubscriberController::class, 'index']);
        Route::get('get/{id}', [SubscriberController::class, 'show']);

        //Route::patch('update', '');
        //Route::delete('delete/{id}', '');
    });

    // Routes for Posts.
    Route::prefix('post')->group(function () {
        Route::post('new', [PostController::class, 'store']);
        Route::get('all', [PostController::class, 'index']);
        Route::get('get/{id}', [PostController::class, 'show']);

        //Route::patch('update', '');
        //Route::delete('delete/{id}', '');
    });
});
