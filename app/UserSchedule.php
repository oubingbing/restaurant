<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/29
 * Time: 17:42
 */

namespace App;


class UserSchedule extends BaseModel
{
    protected $table = 'user_schedules';

    /** FIELD_ID */
    const FIELD_ID = 'ID';

    /** FIELD_ID_USER */
    const FIELD_ID_USER = 'user_id';

    /** FIELD_ID_SCHEDULE */
    const FIELD_ID_SCHEDULE = 'schedule_id';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_USER,
        self::FIELD_ID_SCHEDULE
    ];

    /**
     * 给员工排班
     * @param $employeeId
     * @param $scheduleId
     * @return bool
     */
    public static function assign($employeeId,$scheduleId)
    {
        if (empty($employeeId) || empty($scheduleId))
            return false;

        $result = UserSchedule::create([
            self::FIELD_ID_USER=>$employeeId,
            self::FIELD_ID_SCHEDULE=>$scheduleId
        ]);
        if ($result)
            return $result;
        else
            return false;
    }
}