<?php

namespace App\Http\Middleware;

use App\Permission;
use App\User;
use Closure;
use Illuminate\Support\Facades\Redis;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = $request->session()->has('email');
        $email = $request->session()->get('email');
        if (!$result)
            return redirect('auth/login');

        $userInfo = Redis::hgetall($email);
        if (!$userInfo){
            //重新把数据写入redis,有点吊
            $user = User::query()->where(User::FIELD_EMAIL,$email)->first();
            $user->cacheUserInfo($request,$user);
            $userInfo = Redis::hgetall($email);
        }

            view()->share('user',$userInfo);

        //写入用户信息
        $request->offsetSet('user_info',$userInfo);

        /*$route = \Route::currentRouteName();
        $permission = Permission::searchPermissionByName($route);
        if ($permission){
            $user = User::query()->where(User::FIELD_EMAIL,$email)->first();
            $result = $user->can($permission->name);
            if ($result){
                return $next($request);
            }else{
                echo '无权限';
                return redirect('not_auth');
            }
        }*/

        return $next($request);

    }
}
