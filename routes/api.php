<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/feeds', 'FeedController@index');
Route::get('provider/feeds','FeedController@getForUser');
Route::get('/feeds/{feed}', 'FeedController@show');
Route::put('/feeds/{feed}', 'FeedController@update');
Route::post('/feeds', 'FeedController@store');
Route::delete('/feeds/{feed}', 'FeedController@destroy');
Route::get('/search', 'FeedController@search');


Route::get('/orders', 'OrderController@index');
Route::get('/orders/{order}', 'OrderController@show');
Route::put('/orders/{order}', 'OrderController@update');
Route::post('/orders', 'OrderController@store');
Route::delete('/orders/{order}', 'OrderController@destroy');

Route::post('/register', 'ApiAuthController@register');
Route::post('/login', 'ApiAuthController@login');
Route::put('/update/{user}', 'ApiAuthController@update');

Route::apiResource('image', 'Image/image');
Route::get('file/image_list' , 'FileController@imageList');
Route::post('file/image_list' , 'FileController@imageSave');