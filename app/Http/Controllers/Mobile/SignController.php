<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/2
 * Time: 23:06
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BaseController;
use App\Schedules;
use App\Sign;
use App\UserSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SignController extends BaseController
{
    public function index()
    {
        $userInfo = request()->get('user_info');
        $restaurant = request()->get('restaurant');

        $selfSignLog = Sign::query()
            ->where(Sign::FIELD_ID_EMPLOYEE,$userInfo['id'])
            ->whereBetween(Sign::FIELD_CREATED_AT,[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->get();

        $todayOnDuty = Schedules::where(Schedules::FIELD_ID_RESTAURANT, $restaurant['id'])
            ->where(Schedules::FIELD_WEEK, Carbon::now()->dayOfWeek)
            ->where('start_date', '<=', Carbon::now()->startOfDay())
            ->where('end_date', '>=', Carbon::now()->endOfDay())
            ->get();

        return view('mobile.sign');
    }

    /**
     * 员工签到，已签过则不能重复签
     * @return mixed
     */
    public function sign(Request $request)
    {
        $userInfo = $request->get('user_info');
        $restaurant = $request->get('restaurant');

        $schedule = Schedules::where(Schedules::FIELD_ID_RESTAURANT, $restaurant['id'])
            ->where(Schedules::FIELD_WEEK, Carbon::now()->dayOfWeek)
            ->where('start_date', '<=', Carbon::now()->startOfDay())
            ->where('end_date', '>=', Carbon::now()->endOfDay())
            ->where('start_time', '<=', date('H:i:s'))
            ->where('end_time', '>=', date('H:i:s'))
            ->first();
        if (!$schedule)
            return $this->setStatusCode(500)->responseFail('没有您的排班');

        $userSchedule = UserSchedule::where(UserSchedule::FIELD_ID_USER, $userInfo['id'])
            ->where(UserSchedule::FIELD_ID_SCHEDULE, $schedule->id)->first();
        if (!$userSchedule)
            return $this->setStatusCode(500)->responseFail('没有您的排班');

        $sign = Sign::where(Sign::FIELD_ID_SCHEDULE, $schedule->id)
            ->where(Sign::FIELD_ID_EMPLOYEE, $userInfo['id'])
            ->where('created_at', '>=', date('Y-m-d', strtotime($schedule->start_date)) . ' ' . $schedule->start_time)
            ->where('created_at', '<=', date('Y-m-d', strtotime($schedule->end_date)) . ' ' . $schedule->end_time)
            ->first();

        if ($sign)
            return $this->setStatusCode(500)->responseFail('本班次您已签过了，不能重复签到');

        $hour = (strtotime($schedule->end_time) - strtotime($schedule->start_time)) / (3600);
        $result = Sign::create([
            Sign::FIELD_ID_SCHEDULE => $schedule->{Schedules::FIELD_ID},
            Sign::FIELD_ID_EMPLOYEE => $userInfo['id'],
            Sign::FIELD_ID_RESTAURANT_ID => $schedule->{Schedules::FIELD_ID_RESTAURANT},
            Sign::FIELD_ID_COMPANY => $userInfo['company_id'],
            Sign::FIELD_HOUR => $hour,
            Sign::FIELD_SALARY => $schedule->{Schedules::FIELD_HOUR_SALARY},
            Sign::FIELD_TOTAL_SALARY => ($hour * $schedule->{Schedules::FIELD_HOUR_SALARY})
        ]);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('签到成功',$result);
        else
            return $this->setStatusCode(500)->responseFail('签到失败');
    }

}