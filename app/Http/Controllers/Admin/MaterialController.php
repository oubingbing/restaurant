<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/1
 * Time: 22:05
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
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
}