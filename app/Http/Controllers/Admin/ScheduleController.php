<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/23
 * Time: 14:26
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Schedules;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends BaseController
{
    /**
     * 创建排班
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $userInfo = $request->get('user_info');
        $restaurant = $request->get('restaurant');
        $scheduleData = $request->input();

        $message = [
            'name.required' => '排班名称不能为空',
            'start_date.required' => '该排班的有效起始日期不能为空',
            'start_date.date' => '该排班的有效起始日期必须是日期格式',
            'end_date.required' => '排班的有效截止日期不能为空',
            'end_date.date' => '排班的有效截止日期必须是日期格式',
            'start_time.required' => '该排班上班时间不能为空',
            'start_time.date' => '该排班上班时间必须是日期格式',
            'end_time.required' => '该排班的下班时间不能为空',
            'end_time.date' => '该排班的下班时间必须是日期格式',
            'status.required' => '排班状态不能为空',
            'type.required' => '排班类型不能为空'
        ];
        $validator = Validator::make($scheduleData, [
            'start_date' => 'required | date',
            'end_date' => 'required | date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required',
            'type' => 'required',
        ], $message);
        if ($validator->fails()) {
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $result = Schedules::create([
            Schedules::FIELD_NAME => $scheduleData['name'],
            Schedules::FIELD_START_DATE => $scheduleData['start_date'],
            Schedules::FIELD_END_DATE=>$scheduleData['end_date'],
            Schedules::FIELD_START_TIME=>$scheduleData['start_time'],
            Schedules::FIELD_END_TIME=>$scheduleData['end_time'],
            Schedules::FIELD_ID_USER=>$userInfo['id'],
            Schedules::FIELD_ID_RESTAURANT=>$restaurant['id'],
            Schedules::FIELD_STATUS=>$scheduleData['status'],
            Schedules::FIELD_TYPE=>$scheduleData['type']
        ]);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('创建成功');
        else
            return $this->setStatusCode(500)->responseFail('创建失败');

    }
}