<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/8/23
 * Time: 21:42
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('mobile.login');
    }
}