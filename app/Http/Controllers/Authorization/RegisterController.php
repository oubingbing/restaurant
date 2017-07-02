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

}