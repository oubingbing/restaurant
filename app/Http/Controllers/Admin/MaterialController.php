<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/1
 * Time: 22:05
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Material;
use App\MaterialGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends BaseController
{

    /**
     * 新建一级分组
     * @author yeiz
     * @param (string)name:分组名称
     * @param Request $request
     * @return mixed
     */
    public function createOneLevelGroup(Request $request)
    {
        $restaurant = $request->get('restaurant');
        $name = $request->input('name');

        if (empty($name))
            return $this->setStatusCode(500)->responseError('一级分组名称不能为空');

        $materialGroup = MaterialGroup::where([
            MaterialGroup::FIELD_NAME => $name,
            MaterialGroup::FIELD_ID_RESTAURANT => $restaurant['id']
        ])->first();
        if ($materialGroup)
            return $this->setStatusCode(500)->responseError('该分组名称已存在，不可以重复创建');

        $newMaterialGroup = MaterialGroup::create([
            MaterialGroup::FIELD_NAME => $name,
            MaterialGroup::FIELD_ID_RESTAURANT => $restaurant['id'],
            MaterialGroup::FIELD_TYPE => MaterialGroup::ENUM_ONE_LEVEL_GROUP
        ]);
        if ($newMaterialGroup)
            return $this->setStatusCode(200)->responseSuccess('一级分组创建成功');
        else
            return $this->setStatusCode(500)->responseFail('一级分组创建失败');

    }

    /**
     * 新建二级分组
     * @author yezi
     * @param (string)name:二级分组名称
     * @param (int)one_level_group:所属一级分组
     * @param Request $request
     * @return mixed
     */
    public function createTwoLevelGroup(Request $request)
    {
        $restaurant = $request->get('restaurant');
        $name = $request->input('name');
        $one_level_group = $request->input('one_level_group');

        if (empty($name))
            return $this->setStatusCode(500)->responseError('一级分组名称不能为空');

        $materialGroup = MaterialGroup::where([
            MaterialGroup::FIELD_NAME => $name,
            MaterialGroup::FIELD_ID_RESTAURANT => $restaurant['id']
        ])->first();
        if ($materialGroup)
            return $this->setStatusCode(500)->responseError('该分组名称已存在，不可以重复创建');

        if (empty($one_level_group))
            return $this->setStatusCode(500)->responseError('所属二级分组不能为空');

        $oneLevelGroup = MaterialGroup::where([
            MaterialGroup::FIELD_ID => $one_level_group,
            MaterialGroup::FIELD_ID_RESTAURANT => $restaurant['id']
        ])->first();
        if (!$oneLevelGroup)
            return $this->setStatusCode(500)->responseError('该一级分组不存在');

        $newMaterialGroup = MaterialGroup::create([
            MaterialGroup::FIELD_NAME => $name,
            MaterialGroup::FIELD_ID_RESTAURANT => $restaurant['id'],
            MaterialGroup::FIELD_TYPE => MaterialGroup::ENUM_TWO_LEVEL_GROUP,
            MaterialGroup::FIELD_BELONG_TO => $one_level_group
        ]);
        if ($newMaterialGroup)
            return $this->setStatusCode(200)->responseSuccess('二级分组创建成功');
        else
            return $this->setStatusCode(500)->responseFail('二级分组创建失败');
    }

    /**
     * 创建材料
     * @author yezi
     * @param Request $request
     * @param (string)name:材料名称
     * @param (float)price:材料价格
     * @param (string)unit:单位
     * @param (int)one_level_group:一级分组
     * @param (int)two_level_group:二级分组
     * @return mixed
     */
    public function createMaterial(Request $request)
    {
        $userInfo = $request->get('user_info');
        $restaurant = $request->get('restaurant');
        $material = $request->input();

        $message = [
            'name.required' => '材料名称不能为空',
            'price.required' => '材料价格不能为空',
            'unit.required' => '材料单位不能为空',
            'one_level_group.required' => '一级分组不能为空',
            'one_level_group.exist' => '一级分组不存在',
            'two_level_group.required' => '二级分组不能为空',
            'two_level_group.exist' => '二级分组不存在',
        ];
        $validator = Validator::make($material, [
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'one_level_group' => 'required | exist:material_groups',
            'two_level_group' => 'required | exist:material_groups',
        ], $message);
        if ($validator->fails()) {
            return $this->setStatusCode(500)->responseFail($validator->errors()->first());
        }

        $ifExistMaterial = Material::where([
            Material::FIELD_NAME => $material['name'],
            Material::FIELD_ID_RESTAURANT => $restaurant['id']
        ])->first();
        if ($ifExistMaterial)
            return $this->setStatusCode(500)->responseError('该材料名称已存在，不可重复创建');

        $result = Material::create([
            Material::FIELD_NAME => $material['name'],
            Material::FIELD_PRICE => $material['price'],
            Material::FIELD_UNIT => $material['unit'],
            Material::FIELD_ID_RESTAURANT => $restaurant['id'],
            Material::FIELD_ONE_LEVEL_GROUP => $restaurant['one_level_group'],
            Material::FIELD_TWO_LEVEL_GROUP => $material['two_level_group'],
            Material::FIELD_ID_FOUNDER => $userInfo['id']
        ]);
        if ($result)
            return $this->setStatusCode(200)->responseSuccess('创建成功', $result);
        else
            return $this->setStatusCode(500)->responseFail('创建失败');

    }




}