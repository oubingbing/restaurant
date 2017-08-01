<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/2
 * Time: 16:48
 */

namespace App;


class UserRestaurant extends BaseModel
{
    protected $table = 'user_restaurants';

    protected $fillable = ['user_id', 'restaurant_id', 'company_id'];

    /** FIELD_ID id */
    const FIELD_ID = 'id';

    /** FIELD_ID_USER 用户id */
    const FIELD_USER_ID = 'user_id';

    /** FIELD_RESTAURANT_ID 门店id */
    const FIELD_RESTAURANT_ID = 'restaurant_id';

    /** FIELD_COMPANY_ID 公司id */
    const FIELD_COMPANY_ID = 'company_id';

    /**
     * 分配员工到门店
     * @param $userId
     * @param $restaurantId
     * @param $companyId
     * @return mixed
     */
    public static function assign($userId, $restaurantId, $companyId)
    {
        $userRestaurant = UserRestaurant::query()->where([
            UserRestaurant::FIELD_USER_ID => $userId,
            UserRestaurant::FIELD_RESTAURANT_ID => $restaurantId,
            UserRestaurant::FIELD_COMPANY_ID => $companyId
        ])->first();
        if ($userRestaurant)
            return false;

        $result = UserRestaurant::create([
            'user_id' => $userId,
            'restaurant_id' => $restaurantId,
            'company_id' => $companyId
        ]);

        return $result;
    }

    /**
     * 判断是否是该餐厅的员工
     * @param $employeeId
     * @param $restaurantId
     * @return bool
     */
    public function ifEmployee($employeeId, $restaurantId)
    {
        if (empty($employeeId) || empty($restaurantId))
            return false;

        $result = UserRestaurant::where(self::FIELD_USER_ID, $employeeId)
                                  ->where(self::FIELD_RESTAURANT_ID, $restaurantId)->first();

        if ($result)
            return true;
        else
            return false;

    }

}