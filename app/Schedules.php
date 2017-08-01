<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/29
 * Time: 15:34
 */

namespace App;


class Schedules extends BaseModel
{
    protected $table = 'schedules';

    /** FIELD_ID,排班id */
    const FIELD_ID = 'id';

    /** FIELD_NAME 排班名称 */
    const FIELD_NAME = 'name';

    /** FIELD_START_DATE 排班起始日期 */
    const FIELD_START_DATE = 'start_date';

    /** FIELD_END_DATE 排班截止日期*/
    const FIELD_END_DATE = 'end_date';

    /** FIELD_START_TIME 上班时间 */
    const FIELD_START_TIME = 'start_time';

    /** FIELD_START_TIME 下班时间 */
    const FIELD_END_TIME = 'end_time';

    /** FIELD_ID_USER 创建人 */
    const FIELD_ID_USER = 'user_id';

    /** FIELD_ID_RESTAURANT 创建餐厅 */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

    /** FIELD_STATUS 排班的状态 */
    const FIELD_STATUS = 'status';

    /** FIELD_TYPE 排班类型 */
    const FIELD_TYPE = 'type';

    /** FIELD_WEEK */
    const FIELD_WEEK = 'week';

    /** Field hour_salary */
    const FIELD_HOUR_SALARY = 'hour_salary';

    /** 排班开启 */
    const ENUM_SCHEDULE_OPEN = 1;
    /** 排班关闭 */
    const ENUM_SCHEDULE_CLOSE = 2;

    /** 固定排班 */
    const ENUM_FIXED_SCHEDULE = 1;
    const ENUM_TEMPORARY_SCHEDULE = 2;

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_START_DATE,
        self::FIELD_END_DATE,
        self::FIELD_START_TIME,
        self::FIELD_END_TIME,
        self::FIELD_ID_USER,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_STATUS,
        self::FIELD_TYPE,
        self::FIELD_WEEK
    ];

    public static function searchScheduleById($id)
    {
        if (empty($id))
            return false;

        $result = Schedules::find($id);
        if ($result)
            return true;
        else
            return false;
    }

}