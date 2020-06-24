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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('Api')->group(function (){

    // 首页图片
    Route::get('getbanner','HomeImgController@banner');

    // 首页小图标
    Route::get('getXiao','HomeImgController@getXiao');

    // 首页商品
    Route::get('getHomeGoods','GoodsController@getHomeGoods');
    // 首页商品-分页
    Route::get('getGoodsPage','GoodsController@getGoodsPage');

    // 商品分类
    Route::get('getGoodsType','GoodsTypeController@getGoodsType');

    // 商品详情
    Route::get('getGoodsOne','GoodsController@getOne');

    // 商品-分类-列表
    Route::get('getGoodsList','GoodsController@getGoodsList');

    // 商品搜索
    Route::get('getSearchGoods','GoodsController@getSearchGoods');

    // 手办-小程序登录
    Route::post('userCode','UserController@userCode');

    // 日记-小程序
    Route::post('diaryUserCode','UserController@diaryUserCode');

    Route::group([
        'middleware' => ['jwt']
    ], function () {
        // https://www.cnblogs.com/fstimers/p/12482516.html  线上更新数据
        Route::post('userCodedata','UserController@userCodedata');

        // 日记-添加
        Route::post('diaryAdd','DiaryController@diaryAdd');

        // 日记-修改
        Route::post('diaryEdit','DiaryController@diaryEdit');

        // 日记-删除
        Route::post('diaryDel','DiaryController@diaryDel');

        // 日记-详情
        Route::post('diaryGet','DiaryController@diaryGet');

        // 日记-列表
        Route::get('diaryList','DiaryController@diaryList');



    });

});
