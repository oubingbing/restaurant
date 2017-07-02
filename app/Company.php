<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/25
 * Time: 11:40
 */

namespace App;


class Company extends BaseModel
{
    protected $table = 'companys';

    /** 公司id */
    const FIELD_ID = 'id';

    /** 公司名称 */
    const FIELD_NAME = 'name';

    /** 公司法人代表 */
    const FIELD_LEGAL_REPRESENTATIVE = 'legal_representative';

    /** 机构代码 */
    const FIELD_CODE = 'code';

    /** 联系方式 */
    const FIELD_PHONE = 'phone';

    /** 公司地址 */
    const FIELD_ADDRESS = 'address';

    /** user表外键 */
    const FILED_FOUNDER_ID = 'founder_id';

    protected $fillable = ['name','legal_representative','code','phone','address','founder_id'];

    public static function companyId($userId)
    {
        return Company::query()->where(Company::FILED_FOUNDER_ID,$userId)->value('id');
    }
}