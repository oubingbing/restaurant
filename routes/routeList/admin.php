<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 15:53
 */

Route::group(['prefix'=>'admin','middleware'=>'admin.sky','namespace'=>'Admin'],function (){
    Route::get('/','IndexController@index')->name('entry-admin');//进入后台

    Route::post('/create_company','IndexController@createCompany')->name('create-company');//创建公司
    Route::post('/create_restaurant','IndexController@createRestaurant')->name('create-restaurant');//创建门店
    Route::post('/add_employee','EmployeeController@addEmployee')->name('add-employee');//添加员工
    Route::post('/assign_employee','EmployeeController@assignEmployeeToRestaurant')->name('assign-employee');//分配员工

    Route::get('/restaurant_employee/{restaurantId}','EmployeeController@getRestaurantEmployee')->name('get-restaurant-employee');//获取门店的员工

    Route::put('/test','IndexController@test');

});

Route::group(['middleware'=>'admin.sky','namespace'=>'Entrust'],function (){
    Route::post('create_role','RoleController@store')->name('entrust-create-role');//创建角色
    Route::post('set_role','RoleController@setRole')->name('entrust-setRole-role');//角色关联用户
    Route::post('create_permission','PermissionController@store')->name('entrust-create-permission');//创建权限
    Route::post('set_permission','PermissionController@setPermission')->name('entrust-setRole-role');//权限关联用户

});