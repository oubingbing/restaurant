<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 17:27
 */

namespace App\Http\Controllers\Entrust;


use App\Http\Controllers\BaseController;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
    /**
     * 新建角色
     * @author yezi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('');
    }

    /**
     * 创建角色
     * @author yezi
     * @param Request $request
     *        (string)name:角色名称，
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

        $role = new Role();
        $result = $role->setRole($name,$displayName,$description);
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
    public function setRole(Request $request)
    {
        $userId = $request->input('user_id');
        $roleId = $request->input('role_id');

        if (empty($userId)){
            return $this->setStatusCode(500)->responseError('用户不能为空');
        }
        $user = User::searchUserById($userId);
        if (empty($user))
            return $this->setStatusCode(500)->responseNotFound('用户不存在');

        if (empty($roleId)){
            return $this->setStatusCode(500)->responseError('角色不能为空');
        }
        $role = Role::searchRoleByID($roleId);
        if (empty($role))
            return $this->setStatusCode(500)->responseNotFound('角色不存在');

        $role->attachUser($user);
        return $this->setStatusCode(200)->responseSuccess('操作成功');
    }

}