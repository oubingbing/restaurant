<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 10:36
 */

namespace App;


use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    protected $table = 'roles';

    /** 角色id */
    const FIELD_ID = 'id';

    /** 角色名称 */
    const FIELD_NAME = 'name';

    /** 角色展示名称 */
    const FIELD_DISPLAY_NAME = 'display_name';

    /** 角色的描述 */
    const  FIELD_DESCRIPTION = 'description';

    /**
     * 新建角色
     * @author yezi
     * @param $name
     * @param $displayName
     * @param $description
     * @return mixed
     */
    public function setRole($name,$displayName,$description)
    {
        $this->name = $name;
        $this->display_name = $displayName;
        $this->description = $description;
        $result = $this->save();
        return $result;
    }

    /**
     * 角色关联用户
     * @uathor yezi
     * @param $user
     */
    public function attachUser($user)
    {
        return $user->attachRole($this);
    }

    /**
     * 通过角色id查找角色
     * @author yezi
     * @param $roleId
     * @return object
     */
    public static function searchRoleByID($roleId)
    {
        $result = Role::query()->find($roleId);
        return $result;
    }
}