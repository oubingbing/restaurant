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

    protected $fillable = ['restaurants_name','code','phone','address','company_id'];

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

    /**
     * 获取门店的员工
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employee()
    {
        //Restaurant通过第三方表user_restaurant广联User表
        //第一个参数你要关联的表，第二个参数是第三表，第三个参数是你定义关联关系模型Restaurant的外键名称，第四个参数你要连接到User的模型的外键名称
        return $this->belongsToMany('App\User','user_restaurants','restaurant_id','user_id');
    }

}