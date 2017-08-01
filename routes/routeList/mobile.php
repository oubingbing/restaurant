<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/29
 * Time: 18:04
 */

Route::group(['prefix'=>'mobile','middleware'=>'admin.sky','namespace'=>'Mobile'],function (){
    Route::group(['middleware'=>'admin.restaurant'],function (){
        /** 签到 */
        Route::get('sign','EmployeeController@sign');
    });
});