<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 17:28
 */

namespace App\Http\Controllers\Entrust;


use App\Http\Controllers\BaseController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends BaseController
{
    /**
     * 新建权限
     * @author yezi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('');
    }

    public function getPermissionList()
    {
        $list = Permission::query()->get();
    }

    /**
     * 创建权限
     * @author yezi
     * @param Request $request
     *        (string)name:权限名称，
     *        (string)display_name:展示名称
     *        (string)description:角色描述
     * @return mixed
     */
    public function store(Request $request)
    {
        $name        = $request->input('name');
        $displayName = $request->input('display_name');
        $description = $request->input('description');
        $validator = Validator::make($request->all(),[
            'name'         => 'required | unique:roles',
            'display_name' => 'required',
            'description'  => 'required'
        ]);
        if ($validator->fails()){
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $role = new Permission();
        $result = $role->setPermission($name,$displayName,$description);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('新建成功');
        else
            return $this->setStatusCode(500)->responseFail('新建失败');
    }

    /**
     * 设置用户的角色
     * @author yezi
     * @param Request $request
     *        (int)user_id:用户id
     *        (int)role_id:角色id
     * @return mixed
     */
    public function setPermission(Request $request)
    {
        $RoleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');

        if (empty($RoleId)){
            return $this->setStatusCode(500)->responseError('角色不能为空');
        }
        $role = Role::searchRoleByID($RoleId);
        if (empty($role))
            return $this->setStatusCode(500)->responseNotFound('角色不存在');

        if (empty($permissionId)){
            return $this->setStatusCode(500)->responseError('权限不能为空');
        }
        $permission = Permission::searchPermissionByID($permissionId);
        if (empty($permission))
            return $this->setStatusCode(500)->responseNotFound('权限不存在');

        $permission->attachRole($role);
        return $this->setStatusCode(200)->responseSuccess('操作成功');
    }
}