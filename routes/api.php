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

    // 图片上传
    Route::post('upImage','UpController@upImage');
    // 爬虫
    Route::get('pa','ReptileController@index');

    // 首页图片
    Route::get('getbanner','HomeImgController@banner');

    Route::get('tranTest','TranslationController@tranTest');

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
    // 商品-分类-列表-分页
    Route::get('getGoodsListPage','GoodsController@getGoodsListPage');

    // 商品搜索
    Route::get('getSearchGoods','GoodsController@getSearchGoods');

    // 手办-小程序登录
    Route::post('userCode','UserController@userCode');

    // 日记-小程序-用户登录
    Route::post('diaryUserCode','UserController@diaryUserCode');

    // 日记-首页 日记
    Route::get('homeDiary','HomeDiaryController@indexList');

    // 日记-公共详情
    Route::get('getDetail','HomeDiaryController@getDetail');

    // 评论列表
    Route::get('reviewList','TopicController@reviewList');

    Route::post('login','UserController@login');

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
        Route::get('diaryDel','DiaryController@diaryDel');

        // 日记-详情
        Route::post('diaryGet','DiaryController@diaryGet');

        // 日记-列表
        Route::get('diaryList','DiaryController@diaryList');

        // 日记-日历
        Route::get('getDate','DateController@getDate');




        // 发表评论
        Route::post('reviewAdd','TopicController@reviewAdd');

        // 点赞评论
        Route::post('hit','TopicHitController@hit');




    });

});
