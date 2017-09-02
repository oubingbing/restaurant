<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/9/2
 * Time: 11:24
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class MaterialOrder extends Model
{
    const TABLE_NAME = 'material_orders';
    protected $table = self::TABLE_NAME;

    /** Field id */
    const FIELD_ID = 'id';

    /** Field order_number */
    const FIELD_ORDER_NUMBER = 'order_number';

    /** Field total_amount */
    const FIELD_TOTAL_AMOUNT = 'total_amount';

    /** Field total_number */
    const FIELD_TOTAL_NUMBER = 'total_number';

    /** Field user_id */
    const FIELD_ID_USER = 'user_id';

    /** Field restaurant_id */
    const FIELD_ID_RESTAURANT = 'restaurant_id';

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
        self::FIELD_ORDER_NUMBER,
        self::FIELD_ID_RESTAURANT,
        self::FIELD_TOTAL_AMOUNT,
        self::FIELD_TOTAL_NUMBER,
        self::FIELD_STATUS,
        self::FIELD_TYPE
    ];

}