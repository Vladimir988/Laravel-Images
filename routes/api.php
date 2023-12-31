<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Post', 'prefix' => 'posts'], function() {
    Route::patch('/{post}', 'UpdateController');
    Route::get('/', 'IndexController');

    Route::group(['namespace' => 'Image', 'prefix' => 'images'], function() {
        Route::post('/', 'StoreController');
    });
});
