<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/1
 * Time: 22:22
 */

namespace App;


class MaterialGroup extends BaseModel
{
    protected $table = 'material_groups';

    /** Field id */
    const FIELD_ID = 'id';

    /** Field name 分组名称 */
    const FIELD_NAME = 'name';

    /** Field restaurant_id 所属餐id */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

    /** Field type 分组类型 */
    const FIELD_TYPE = 'type';

    /** Field status 分组状态 */
    const FIELD_STATUS = 'status';

    /** Field belong_to 所属分组id */
    const FIELD_BELONG_TO = 'belong_to';

    /** Enum type=1 一级分组 */
    const ENUM_ONE_LEVEL_GROUP = 1;
    /** Enum type=2 二级分组 */
    const ENUM_TWO_LEVEL_GROUP = 2;

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_TYPE,
        self::FIELD_BELONG_TO,
        self::FIELD_STATUS
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    /**
     * 获取分组列表,根据传递的分组参数获取分组列表
     * @author yezi
     * @param $restaurant_id
     * @param $group
     * @return array
     */
    public static function Group($restaurant_id, $group)
    {
        if (empty($restaurant_id) || empty($group))
            return ['status' => false, 'message' => '参数错误，有空数据', 'data' => null];

        if (!in_array($group,[self::ENUM_ONE_LEVEL_GROUP,self::ENUM_TWO_LEVEL_GROUP]))
            return ['status' => false, 'message' => '参数错误', 'data' => null];

        $oneLevelGroup = self::where([
            self::FIELD_ID_RESTAURANT => $restaurant_id,
            self::FIELD_TYPE => $group
        ])->get([self::FIELD_ID, self::FIELD_NAME]);
        if ($oneLevelGroup)
            return ['status' => true, 'message' => '获取成功', 'data' => $oneLevelGroup];
        else
            return ['status' => false, 'message' => '没有相关数据', 'data' => null];

    }

}