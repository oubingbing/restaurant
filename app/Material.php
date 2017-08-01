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

    /** Field value 单位含量 */
    const FIELD_VALUE = 'value';

    /** Field restaurant id 所属餐厅id */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

    /** Field one level group 所属一级分组 */
    const FIELD_ONE_LEVEL_GROUP = 'one_level_group';

    /** Field one level group 所属二级分组 */
    const FIELD_TWO_LEVEL_GROUP = 'two_level_group';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_PRICE,
        self::FIELD_UNIT,
        self::FIELD_VALUE,
        self::FIELD_ONE_LEVEL_GROUP,
        self::FIELD_TWO_LEVEL_GROUP
    ];
}