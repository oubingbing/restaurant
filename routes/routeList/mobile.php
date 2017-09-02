<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/29
 * Time: 18:04
 */

Route::group(['prefix' => 'mobile', 'namespace' => 'Mobile'], function () {
    Route::get('login', 'AuthController@index');
});

Route::group(['prefix' => 'mobile', 'middleware' => ['admin.restaurant','admin.sky'], 'namespace' => 'Mobile'], function () {
    /** 签到页面 */
    Route::get('sign', 'SignController@index');

    /** 点击签到 */
    Route::patch('sign', 'SignController@sign');

    Route::get('purchase','PurchaseController@index');
});