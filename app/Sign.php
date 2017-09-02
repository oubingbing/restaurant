<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/29
 * Time: 20:49
 */

namespace App;


class Sign extends BaseModel
{
    protected $table = 'signs';

    /** Field id */
    const FIELD_ID = 'id';

    /** Field schedule_id */
    const FIELD_ID_SCHEDULE = 'schedule_id';

    /** Field employee_id */
    const FIELD_ID_EMPLOYEE = 'employee_id';

    /** Field restaurant_id */
    const FIELD_ID_RESTAURANT_ID = 'restaurant_id';

    /** Field company_id */
    const FIELD_ID_COMPANY = 'company_id';

    /** Field hour */
    const FIELD_HOUR = 'hour';

    /** Field salary */
    const FIELD_SALARY = 'salary';

    /** Field total_salary */
    const FIELD_TOTAL_SALARY = 'total_salary';

    /** Field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** Field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_SCHEDULE,
        self::FIELD_ID_EMPLOYEE,
        self::FIELD_ID_RESTAURANT_ID,
        self::FIELD_ID_COMPANY,
        self::FIELD_HOUR,
        self::FIELD_SALARY,
        self::FIELD_TOTAL_SALARY
    ];

}