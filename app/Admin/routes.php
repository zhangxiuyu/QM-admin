<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    // 配置文件
    $router->resource('config','ConfigController');

    // 首页-banner
    $router->resource('homeImg','HomeImgController');

    // 首页-小图标
    $router->resource('homexiao','HomeXiaoController');

    // 商品管理
    $router->resource('goods','GoodsController');

    // 分类
    $router->get('goodsType','GoodsTypeController@goodsType');
    $router->get('goodsTypeXiao','GoodsController@goodsTypeXiao');
    //  版本管理-项目列表
    $router->resource('versions','VersionsController');


    // 分类新增
    $router->get('createType/{courseId}/{name}','GoodsTypeController@createType');
    // 修改
    $router->get('editType/{courseId}/{name}','GoodsTypeController@editType');

    $router->post('handleCreate/{courseId}/{name}','GoodsTypeController@handleCreate');
    $router->put('handleCreate/{courseId}/{name}','GoodsTypeController@handleCreate');



});
