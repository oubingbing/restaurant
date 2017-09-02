<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 15:14
 */

namespace App\Http\Controllers\Authorization;


use App\Http\Controllers\BaseController;
use App\Restaurant;
use App\User;
use App\UserRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends BaseController
{
    /**
     * 登录页面
     * @author yezi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth/login');
    }

    /**
     * 登录
     * @author yezi
     * @param $request
     *        (string)email:用户邮箱
     *        (string)password:密码
     * @return mixed
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $type = $request->input('type');

        if (empty($email))
            return $this->setStatusCode(500)->responseError('登录邮箱不能为空');

        if (empty($password))
            return $this->setStatusCode(500)->responseError('密码不能为空');

        $user = User::query()->where(User::FIELD_EMAIL,$email)->first();
        if (!$user){
            return $this->setStatusCode(404)->responseNotFound('用户不存在或密码错误');
        }

        if (!$user['founder'] && $user['status'] == 1){
            return $this->setStatusCode(500)->responseFail('账户未激活');
        }

        if ($password.$user->salt === decrypt($user->password)){
            $userInfo = $user->cacheUserInfo($request,$user);

            if ($type == 'mobile'){
                $userRestaurant = UserRestaurant::where(UserRestaurant::FIELD_USER_ID,$userInfo['id'])->first();
                Restaurant::cacheRestaurant($userRestaurant->restaurant,$request);
            }

            return $this->setStatusCode(200)->responseSuccess('登录成功',$userInfo);
        }else{
            return $this->setStatusCode(500)->responseFail('用户不存在或密码错误');
        }
    }

    public function activateAccount()
    {
        return view('auth.activateAccount');
    }

    /**
     * 登出用户
     * @author yezi
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $result = User::clearUserInfo($request);

        if ($result)
            return redirect('auth/login');
        else
            return $this->setStatusCode(500)->responseFail('操作失败');
    }
}