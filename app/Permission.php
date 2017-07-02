<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 10:38
 */

namespace App;


use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected $table = 'permissions';

    /** 权限id */
    const FIELD_ID = 'id';

    /** 权限名称 */
    const FIELD_NAME = 'name';

    /** 权限展示名称 */
    const FIELD_DISPLAY_NAME = 'display_name';

    /** 权限的描述 */
    const  FIELD_DESCRIPTION = 'description';

    /**
     * 新建角色
     * @author yezi
     * @param $name
     * @param $displayName
     * @param $description
     * @return mixed
     */
    public function setPermission($name,$displayName,$description)
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
     * @param $role
     */
    public function attachRole($role)
    {
        return $role->attachPermission($this);
    }

    /**
     * 通过角色id查找角色
     * @author yezi
     * @param $permissionId
     * @return object
     */
    public static function searchPermissionByID($permissionId)
    {
        $result = Permission::query()->find($permissionId);
        return $result;
    }

    public static function searchPermissionByName($name)
    {
        $result = Permission::query()->where('name',$name)->first();
        return $result;
    }

}