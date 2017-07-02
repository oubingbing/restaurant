<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/24
 * Time: 15:50
 */

namespace App\Http\Controllers\Admin;


use App\Company;
use App\Http\Controllers\BaseController;
use App\Mail\ActivateAccount;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class IndexController extends BaseController
{
    /**
     * 后台首页
     * @author yezi
     * @return string
     */
    public function index()
    {
        return 'welcome to admin';
    }

    /**
     * 创建公司
     * @author yezi
     * @param Request $request,
     *        (string)name:公司名称，
     *        (string)legal_representative:法人代表，
     *        (string)phone:联系电话，
     *        (string)address:公司地址
     *        (string)code:机构代码
     * @return mixed
     */
    public function createCompany(Request $request)
    {
        $companyData = $request->only(['name','legal_representative','phone','address','code']);

        $rules = [
            'name'                 => 'required | unique:companys',
            'legal_representative' => 'required',
            'phone'                => 'required',
            'address'              => 'required'
        ];
        $message = [
            'name.required'                  => '公司名称不能为空',
            'name.unique'                    => '公司名称已存在',
            'legal_representative.required'  => '公司法人代表不能为空',
            'phone.required'                 => '公司联系方式不能为空',
            'address.required'               => '公司地址不能为空',
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()){
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $userId = User::userId($request->session()->get('email'));
        $companyData['founder_id'] = $userId;

        $result = Company::create($companyData);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('提交成功',$result);
        else
            return $this->setStatusCode(500)->responseFail('创建失败');

    }

    /**
     * 创建餐厅
     * @author yezi
     * @param Request $request
     *        (string)restaurants_name:餐厅名称
     *        (string)code:餐厅机构代码
     *        (string)phone:联系电话
     *        (string)address:餐厅地址
     * @return mixed
     */
    public function createRestaurant(Request $request)
    {
        $restaurant = $request->only(['restaurants_name','phone','address','code']);

        $rules = [
            'restaurants_name'      => 'required | unique:restaurants',
            'phone'                => 'required',
            'address'              => 'required'
        ];
        $message = [
            'restaurants_name.required'      => '餐厅名称不能为空',
            'restaurants_name.unique'        => '餐厅名称已存在',
            'phone.required'                 => '餐厅联系方式不能为空',
            'address.required'               => '餐厅地址不能为空',
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()){
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $companyId =Company::companyId(User::userId($request->session()->get('email')));
        $restaurant['company_id'] = $companyId;

        $result = Restaurant::create($restaurant);
        if ($request)
            return $this->setStatusCode(200)->responseSuccess('创建成功',$result->makeHidden(['id','crateed_at']));
        else
            return $this->setStatusCode(500)->responseFail('创建失败');
    }

    /**
     * 添加员工
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
}