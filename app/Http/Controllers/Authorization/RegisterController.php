<?php

/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/18
 * Time: 11:15
 */

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * 注册页面
     * @author yezi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * 用户注册
     * @author yezi
     * @param Request $request,
     *        (string)name:用户名，
     *        (string)email:邮箱，
     *        (string)password:密码，
     *        (string)password_confirmation:确认密码
     * @return mixed
     */
    public function store(Request $request)
    {
        $name     = $request->input('name');
        $email    = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all(),[
            'name' => 'required | max:32',
            'email' => 'required | email | unique:users',
            'password' => 'required | min:6 | max:32 |confirmed',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()){
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $user = new User();
        $result = $user->register($name,$email,$password);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('注册成功');
        else
            return $this->setStatusCode(500)->responseFail('注册失败');
    }

    /**
     * 激活账号页面
     * @athor yezi
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activateAccount($token)
    {
        if (!$token)
            abort(404,'页面丢失了');

        $user = User::query()->where(User::FIELD_ACTIVATE_TOKEN,$token)->first();
        if (!$user)
            abort(404,'找不到用户');

        if (time() > time($user->{User::FIELD_ACTIVATE_TIME})){
            abort(404,'链接已过期');
        }

        return view('auth.activateAccount',['user'=>$user]);
    }

    /**
     * 更新员工信息
     * @author yezi
     * @param Request $request
     *        (string)name:用户名，
     *        (string)email:邮箱，
     *        (string)password:密码，
     *        (string)password_confirmation:确认密码
     * @param $token
     * @return mixed
     */
    public function refreshEmployeeInfo(Request $request,$token)
    {
        if (!$token)
            return $this->setStatusCode(500)->responseError('token不能为空');

        $name     = $request->input('username');
        $email    = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all(),[
            'username' => 'required | max:32',
            'email' => 'required | email',
            'password' => 'required | min:6 | max:32 |confirmed',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()){
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $user = User::query()->where([User::FIELD_ACTIVATE_TOKEN=>$token,User::FIELD_EMAIL=>$email])->first();
        if (!$user)
            return $this->setStatusCode(500)->responseNotFound('没有找到您的账号信息');

        if ($user->{User::FIELD_STATUS} == User::ENUM_STATUS_ACTIVE)
            return $this->setStatusCode(500)->responseNotFound('您的账号已激活无需重复激活');

        $user->username = $name;
        $user->password = encrypt($password.$user->salt);
        $user->status = User::ENUM_STATUS_ACTIVE;
        $result = $user->save();
        if ($result)
            return $this->setStatusCode(500)->responseSuccess('提交成功');
        else
            return $this->setStatusCode(500)->responseFail('提交失败');

    }

}