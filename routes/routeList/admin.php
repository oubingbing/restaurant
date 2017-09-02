<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 15:53
 */


use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ScheduleController;

Route::group(['prefix'=>'admin','middleware'=>'admin.sky','namespace'=>'Admin'],function (){
    Route::get('/','IndexController@index')->name('entry-admin');//进入后台
    /** 选择餐厅 */
    Route::get('select_restaurant/{id}','IndexController@selectRestaurant');

    Route::group(['middleware'=>'admin.restaurant'],function (){
        /** 创建排班 */
        Route::post('create_schedule','ScheduleController@create');

        /** 修改排班 */
        Route::post('edit_schedule','ScheduleController@update');

        /** 获取排班列表 */
        Route::get('schedules_employees','ScheduleController@schedulesAndEmployees');

        /** 给员工排班 */
        Route::post('assign_schedule','ScheduleController@assign');

        /** 材料主页面 */
        Route::get('material','MaterialController@index');

        /** 新建一级分组 */
        Route::post('create_group_one','MaterialController@createOneLevelGroup');

        /** 获取一级分组列表 */
        Route::get('group_list','MaterialController@groupList');

        /** 新建二级分组 */
        Route::post('create_group_two','MaterialController@createTowLevelGroup');

        /** 新建材料 */
        Route::post('create_material','MaterialController@createMaterial');
        /** 获取材料详情 */
        Route::get('material/{id}/detail','MaterialController@materialDetail');
        /** 获取材料列表 */
        Route::get('materials','MaterialController@materialList');
    });

    Route::post('/create_company','IndexController@createCompany')->name('create-company');//创建公司
    Route::post('/create_restaurant','IndexController@createRestaurant')->name('create-restaurant');//创建门店

    /** 新建员工页面 */
    Route::get('employee','EmployeeController@index');

    /** 新建员工 */
    Route::post('add_employee','EmployeeController@addEmployee')->name('add-employee');//添加员工

    /** 分配员工 */
    Route::post('assign_employee',EmployeeController::class.'@assignEmployeeToRestaurant')->name('assign-employee');//分配员工

    Route::get('restaurant_employee/{restaurantId}','EmployeeController@getRestaurantEmployee')->name('get-restaurant-employee');//获取门店的员工

});

Route::group(['middleware'=>'admin.sky','namespace'=>'Entrust'],function (){
    Route::post('create_role','RoleController@store')->name('entrust-create-role');//创建角色
    Route::post('set_role','RoleController@setRole')->name('entrust-setRole-role');//角色关联用户
    Route::post('create_permission','PermissionController@store')->name('entrust-create-permission');//创建权限
    Route::post('set_permission','PermissionController@setPermission')->name('entrust-setRole-role');//权限关联用户

});