<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class Restaurant
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

        $restaurant = Redis::hgetall('restaurant_'.$email);
        if (!$restaurant){
            //重新把数据写入redis,有点吊
            dd('请选择餐厅');
//            return redirect('请选择餐厅');
        }

        //写入餐厅信息
        $request->offsetSet('restaurant',$restaurant);

        return $next($request);
    }
}
