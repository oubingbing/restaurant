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
use App\UserRestaurant;
use App\UserSchedule;
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
            'type.required' => '排班类型不能为空',
            'week.required' => '周几不能为空',
            'hour_salary.required' => '工资不能为空'
        ];
        $validator = Validator::make($scheduleData, [
            'start_date' => 'required | date',
            'end_date' => 'required | date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required',
            'type' => 'required',
            'week' => 'required',
            'hour_salary' => 'required'
        ], $message);
        if ($validator->fails()) {
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $result = Schedules::create([
            Schedules::FIELD_NAME => $scheduleData['name'],
            Schedules::FIELD_START_DATE => $scheduleData['start_date'],
            Schedules::FIELD_END_DATE => $scheduleData['end_date'],
            Schedules::FIELD_START_TIME => $scheduleData['start_time'],
            Schedules::FIELD_END_TIME => $scheduleData['end_time'],
            Schedules::FIELD_ID_USER => $userInfo['id'],
            Schedules::FIELD_ID_RESTAURANT => $restaurant['id'],
            Schedules::FIELD_STATUS => $scheduleData['status'],
            Schedules::FIELD_TYPE => $scheduleData['type'],
            Schedules::FIELD_WEEK => $scheduleData['week'],
            Schedules::FIELD_HOUR_SALARY => $scheduleData['hour_salary']
        ]);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('创建成功');
        else
            return $this->setStatusCode(500)->responseFail('创建失败');
    }

    public function update($id)
    {

    }

    public function delete()
    {

    }

    /**
     * 给员工排班
     * @author yezi
     * @param (int)employee_id:员工id
     * @param (int)schedule_id:班次id
     * @param Request $request
     * @return mixed
     */
    public function assign(Request $request)
    {
        $userId = $request->input('employee_id');
        $scheduleId = $request->input('schedule_id');

        if (empty($userId))
            return $this->setStatusCode(500)->responseError('员工不能为空');

        $employee = User::searchUserById($userId);
        if (!$employee)
            return $this->setStatusCode(500)->responseError('员工不存在');

        if (empty($scheduleId))
            return $this->setStatusCode(500)->responseError('排班不能为空');

        $schedule = Schedules::searchScheduleById($scheduleId);
        if (!$schedule)
            return $this->setStatusCode(500)->responseError('排班不存在');

        $schedule = UserSchedule::where([
            UserSchedule::FIELD_ID_USER => $userId,
            UserSchedule::FIELD_ID_SCHEDULE => $scheduleId
        ])->first();
        if ($schedule)
            return $this->setStatusCode(500)->responseError('已有该员工的排班，不能重复排班');

        $result = UserSchedule::assign($userId, $scheduleId);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('排班成功', $result);
        else
            return $this->setStatusCode(500)->responseFail('排班失败');

    }

}