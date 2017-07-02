<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/25
 * Time: 11:44
 */

namespace App;


class Restaurant extends BaseModel
{
    protected $table = 'restaurants';

    /** 餐厅id */
    const FIELD_ID = 'id';

    /** 餐厅名字 */
    const FIELD_RESTAURANT_NAME = 'restaurants_name';

    /** 机构代码 */
    const FIELD_CODE = 'code';

    /** 联系方式 */
    const FIELD_PHONE = 'phone';

    /** 餐厅地址 */
    const FIELD_ADDRESS = 'address';

    /** 公司表外键 */
    const FIELD_COMPANY_ID = 'company_id';

    protected $fillable = ['restaurants_name','code','phone','address','company_id'];
}