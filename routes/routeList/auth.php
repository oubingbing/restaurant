<?php
/**
 * 权限路由文件
 * @author yezi
 */

Route::group(['prefix'=>'auth','namespace'=>'Authorization'],function (){
    Route::get('/register','RegisterController@index')->name('register-index');
    Route::post('/register','RegisterController@store')->name('register-store');
    Route::get('/login','LoginController@index')->name('login.get');
    Route::post('/login','LoginController@login')->name('login.post');
    Route::get('/logout','LoginController@logout')->name('logout.post');

    Route::get('activate/{token}','RegisterController@activateAccount')->name('activate.get');
    Route::post('activate/{token}','RegisterController@refreshEmployeeInfo')->name('activate.post');
});