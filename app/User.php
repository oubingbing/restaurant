<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $table = 'users';

    /** status状态值的描述 */
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;

    /** 用户id */
    const FIELD_ID = 'id';

    /** 用户名 */
    const FIELD_NAME = 'name';

    /** 邮箱，唯一 */
    const FIELD_EMAIL = 'email';

    /** 密码 */
    const  FIELD_PASSWORD = 'password';

    /** 用户的激活状态 */
    const FIELD_STATUS = 'status';

    /** 盐值 */
    const FIELD_SALT = 'salt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','deleted_at','salt'
    ];

    /**
     * 保存注册信息
     * @author yezi
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public function register($name,$email,$password)
    {
        $salt = random_int(1000,10000);

        $this->name     = $name;
        $this->email    = $email;
        $this->password = encrypt($password.$salt);
        $this->salt     = $salt;
        $result = $this->save();

        if ($result)
            return true;
        else
            return false;
    }

    /**
     * 缓存用户数据
     * @author yezi
     * @param $request
     * @param $user
     */
    public function cacheUserInfo($request,$user)
    {
        $request->session()->forget('email');
        $request->session()->put('email',$user->email);
        $email = $request->session()->get('email');

        Redis::hmset($email,$user->toArray());
        $userInfo = Redis::hgetall($email);
        return $userInfo;
    }

    /**
     * 清除用户数据
     * @author yezi
     * @param $request
     */
    public static function clearUserInfo($request)
    {
        $email = $request->session()->get('email');
        $request->session()->forget('email');

        return Redis::del($email);
    }

    /**
     * 获取用户信息
     * @author yezi
     * @param $email
     * @return mixed
     */
    public static function UserInfo($email)
    {
        return Redis::hgetall($email);
    }

    /**
     * 获取用户id
     * @author yezi
     * @param string $email
     * @return mixed
     */
    public static function userId($email = '')
    {
        return Redis::hget($email,'id');
    }

    /**
     * 获取用户名
     * @param $email
     * @return mixed
     */
    public function userName($email)
    {
        return Redis::hget($email,'name');
    }

    public static function searchUserById($userId)
    {
        $result = User::query()->find($userId);
        return $result;
    }
}
