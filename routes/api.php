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

Route::namespace('Api')->group(function (){

    // 首页图片
    Route::get('getbanner','HomeImgController@banner');

    // 首页小图标
    Route::get('getXiao','HomeImgController@getXiao');

    // 首页商品
    Route::get('getHomeGoods','GoodsController@getHomeGoods');

});
