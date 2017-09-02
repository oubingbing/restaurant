<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/9/2
 * Time: 11:13
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class MaterialCars extends Model
{
    const TABLE_NAME = 'material_cars';
    protected $table = self::TABLE_NAME;

    /** Field id */
    const FIELD_ID = 'id';

    /** Field user_id */
    const FIELD_ID_USER = 'user_id';

    /** Field restaurant_id */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

    /** Field material_id */
    const FIELD_ID_MATERIAL = 'material_id';

    /** Field amount */
    const FIELD_AMOUNT = 'amount';

    /** Field number */
    const FIELD_NUMBER = 'number';

    /** Field ordered_at */
    const FIELD_ORDER_AT = 'ordered_at';

    /** Field status */
    const FIELD_STATUS = 'status';

    /** Field type */
    const FIELD_TYPE = 'type';

    /** Field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** Field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** Field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::FIELD_ID_USER,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_ID_MATERIAL,
        self::FIELD_AMOUNT,
        self::FIELD_NUMBER,
        self::FIELD_STATUS,
        self::FIELD_TYPE,
        self::FIELD_ORDER_AT
    ];

}