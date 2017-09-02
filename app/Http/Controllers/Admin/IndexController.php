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
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends BaseController
{
    /**
     * 后台首页
     * @author yezi
     * @return string
     */
    public function index(Request $request)
    {
        $userInfo = $request->get('user_info');

        $restaurantList = Restaurant::where(Restaurant::FIELD_COMPANY_ID,$userInfo['company_id'])->get();

        return view('admin.index',['restaurants'=>$restaurantList]);
    }

    /**
     * 选择餐厅
     * @author yezi
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function selectRestaurant(Request $request, $id)
    {
        $userInfo = $request->get('user_info');
        if (empty($id))
            return $this->setStatusCode(500)->responseError('餐厅不能为空');

        $restaurant = Restaurant::where([
            Restaurant::FIELD_ID => $id,
            Restaurant::FIELD_COMPANY_ID => $userInfo[Restaurant::FIELD_COMPANY_ID]
        ])->first();

        if ($restaurant){
            Restaurant::cacheRestaurant($restaurant,$request);
            return view('admin/restaurant',['restaurant'=>$restaurant]);
        }
        else
            return $this->setStatusCode(500)->responseFail('选择失败,该餐厅不存在');

    }

    /**
     * 创建公司
     * @author yezi
     * @param Request $request ,
     *        (string)name:公司名称，
     *        (string)legal_representative:法人代表，
     *        (string)phone:联系电话，
     *        (string)address:公司地址
     *        (string)code:机构代码
     * @return mixed
     */
    public function createCompany(Request $request)
    {
        $companyData = $request->only(['name', 'legal_representative', 'phone', 'address', 'code']);

        $rules = [
            'name' => 'required | unique:companys',
            'legal_representative' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ];
        $message = [
            'name.required' => '公司名称不能为空',
            'name.unique' => '公司名称已存在',
            'legal_representative.required' => '公司法人代表不能为空',
            'phone.required' => '公司联系方式不能为空',
            'address.required' => '公司地址不能为空',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $userId = User::userId($request->session()->get('email'));
        $companyData['founder_id'] = $userId;

        $result = Company::create($companyData);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('提交成功', $result);
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
        $restaurant = $request->only(['restaurants_name', 'phone', 'address', 'code']);

        $rules = [
            'restaurants_name' => 'required | unique:restaurants',
            'phone' => 'required',
            'address' => 'required'
        ];
        $message = [
            'restaurants_name.required' => '餐厅名称不能为空',
            'restaurants_name.unique' => '餐厅名称已存在',
            'phone.required' => '餐厅联系方式不能为空',
            'address.required' => '餐厅地址不能为空',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $companyId = Company::companyId(User::userId($request->session()->get('email')));
        $restaurant['company_id'] = $companyId;

        $result = Restaurant::create($restaurant);
        if ($request)
            return $this->setStatusCode(200)->responseSuccess('创建成功', $result->makeHidden(['id', 'crateed_at']));
        else
            return $this->setStatusCode(500)->responseFail('创建失败');
    }


}