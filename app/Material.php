<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/1
 * Time: 22:30
 */

namespace App;


class Material extends BaseModel
{

    protected $table = 'materials';

    /** Field id */
    const FIELD_ID = 'id';

    /** Field name 材料名称 */
    const FIELD_NAME = 'name';

    /** Field price 材料价格 */
    const FIELD_PRICE = 'price';

    /** Field unit 材料单位 */
    const FIELD_UNIT = 'unit';

    /** Field restaurant id 所属餐厅id */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

    /** Field one level group 所属一级分组 */
    const FIELD_ONE_LEVEL_GROUP = 'one_level_group';

    /** Field one level group 所属二级分组 */
    const FIELD_TWO_LEVEL_GROUP = 'two_level_group';

    /** Field founder id 创建人 */
    const FIELD_ID_FOUNDER = 'founder_id';

    /** Field type 材料类型 */
    const FIELD_TYPE = 'type';

    /** 物料 */
    const ENUM_TYPE_FOOD = 1;
    /** 食材 */
    const ENUM_TYPE_MATERIAL = 2;

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_PRICE,
        self::FIELD_UNIT,
        self::FIELD_ONE_LEVEL_GROUP,
        self::FIELD_TWO_LEVEL_GROUP,
        self::FIELD_ID_FOUNDER,
        self::FIELD_TYPE
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    /*protected $appends = [
        'one_group'
    ];*/

    /**
     * 获取一级分组
     * @author yezi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oneLevelGroup()
    {
        return $this->belongsTo(MaterialGroup::class,self::FIELD_ONE_LEVEL_GROUP,MaterialGroup::FIELD_ID);
    }

    /**
     * 获取二级分组
     * @author yezi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function twoLevelGroup()
    {
        return $this->belongsTo(MaterialGroup::class,self::FIELD_TWO_LEVEL_GROUP,MaterialGroup::FIELD_ID);
    }

    /**
     * 根据type获取材料列表信息
     * @author yezi
     * @param $restaurantId
     * @param int $type
     * @param null $groupId
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function materials($restaurantId,$type=0,$groupId=null)
    {

        if (empty($restaurantId))
            return false;

        $material = self::query()->where(self::FIELD_ID_RESTAURANT,$restaurantId);
        if (!empty($groupId)){
            if ($type = 1){
                $material->where(self::FIELD_ONE_LEVEL_GROUP,$groupId);
            }

            if ($type = 2){
                $material->where(self::FIELD_TWO_LEVEL_GROUP,$groupId);
            }
        }

        $result = $material->get([
            self::FIELD_ID,
            self::FIELD_NAME,
            self::FIELD_PRICE,
            self::FIELD_UNIT,
            self::FIELD_ID_RESTAURANT,
            self::FIELD_ONE_LEVEL_GROUP,
            self::FIELD_TWO_LEVEL_GROUP,
            self::FIELD_ID_FOUNDER
        ]);
        return $result;

    }

}