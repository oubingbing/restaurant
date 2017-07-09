<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/7/2
 * Time: 16:36
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Mail\ActivateAccount;
use App\Restaurant;
use App\User;
use App\Company;
use App\UserRestaurant;
use Illuminate\Http\Request;
use Mail;

class EmployeeController extends BaseController
{
    /**
     * 添加新员工
     * @author yezi
     * @param Request $request,
     *       (string)email:员工邮箱
     * @return mixed
     */
    public function addEmployee(Request $request)
    {
        $email = $request->input('email');

        if (empty($email))
            return $this->setStatusCode(500)->responseError('邮箱不能为空');

        $checkEmail = User::query()->where(User::FIELD_EMAIL,$email)->value('email');
        if ($checkEmail)
            return $this->setStatusCode(200)->responseError('邮箱已存在');

        $user =  User::create([
            'username'       => 'clock',
            'email'          => $email,
            'password'       => 'clock',
            'salt'           => random_int(1000,10000),
            'activate_token' => str_random(50),
            'company_id'     => Company::companyId(User::userId($request->session()->get('email')))
        ]);

        if ($user){
            Mail::to($email)->send(new ActivateAccount($user));
            return $this->setStatusCode(200)->responseSuccess('添加员工成功，请员工登录邮箱激活账号');
        }else{
            return $this->setStatusCode(500)->responseFail('添加失败');
        }

    }

    /**
     * 获取公司的员工
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCompanyEmployee(Request $request)
    {
        $companyId = User::companyId($this->getSessionEmail($request));
        $employeeList = User::query()->where([User::FIELD_COMPANY_ID=>$companyId,User::FIELD_STATUS=>User::STATUS_ACTIVE])->get(['id','username']);
        return $employeeList;
    }

    /**
     * 分配员工
     * @author yezi
     * @param Request $request
     *        (int)employee_id:员工id
     *        (int)restaurant_id:餐厅id
     * @return mixed
     */
    public function assignEmployeeToRestaurant(Request $request)
    {
        $employeeId   = $request->input('employee_id');
        $restaurantId = $request->input('restaurant_id');

        if (empty($employeeId))
            return $this->setStatusCode(500)->responseError('员工不能为空');

        if (empty($restaurantId))
            return $this->setStatusCode(500)->responseError('店铺不能为空');

        $companyId = User::companyId($this->getSessionEmail($request));
        $user = User::query()->where([User::FIELD_ID=>$employeeId,User::FIELD_COMPANY_ID=>$companyId])->first();
        if (!$user)
            return $this->setStatusCode(500)->responseError('员工不存在');

        $restaurant = Restaurant::query()->where([Restaurant::FIELD_ID=>$restaurantId,Restaurant::FIELD_COMPANY_ID=>$companyId])->first();
        if (!$restaurant)
            return $this->setStatusCode(500)->responseError('门店不存在不存在');

        $result = UserRestaurant::assign($employeeId,$restaurantId,$companyId);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('提交成功');
        else
            return $this->setStatusCode(500)->responseFail('提交失败');
    }

    /**
     * 获取门店的员工
     * @param（int）$restaurantId:门店id
     * @return object
     */
    public function getRestaurantEmployee($restaurantId)
    {
        if (!$restaurantId)
            return $this->setStatusCode(500)->responseError('餐厅不能为空');

        //通过第三方表获取门店的员工
        $restaurant = Restaurant::find($restaurantId);
        if (!empty($restaurant)){
            $employeeList = collect($restaurant->employee)->map(function ($value){
               return collect($value)->only(['id','username']);
            });
        }else{
            $employeeList = [];
        }

        return $employeeList;
    }

    public function createSchedule()
    {
        
    }

}