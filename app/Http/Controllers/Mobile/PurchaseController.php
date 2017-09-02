<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/2
 * Time: 23:04
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BaseController;
use App\Material;
use Illuminate\Http\Request;

class PurchaseController extends BaseController
{

    /**
     * 采购首页
     * @author yezi
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $restaurant = $request->get('restaurant');

        $materials = Material::materials($restaurant['id']);

        return view('mobile.purchase_index',['materials'=>$materials]);
    }
}