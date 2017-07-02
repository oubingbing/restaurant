<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/18
 * Time: 11:55
 */

namespace App\Http\Controllers;


class BaseController extends Controller
{
    protected $statusCode = 200;
    protected $message;
    protected $data;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return object
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 返回成功
     * @author yezi
     * @param $message
     * @param string $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($message,$data='')
    {
        return $this->response('success',$message,$data);
    }

    /**
     * 返回失败
     * @author yezi
     * @param $message
     * @param string $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseFail($message,$data='')
    {
        return $this->response('fail',$message,$data);
    }

    /**
     * 返回错误
     * @author yezi
     * @param $message
     * @param string $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message,$data='')
    {
        return $this->response('error',$message,$data);
    }

    /**
     * 返回未找到
     * @author yezi
     * @param $message
     * @param string $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound($message,$data='')
    {
        return $this->response('not found',$message,$data);
    }

    /**
     * 创建统一的返回方式
     * @author yezi
     * @param $message
     * @param string $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($status='',$message,$data='')
    {
        return response()->json([
            'status'      => $status,
            'status_code' => $this->statusCode,
            'message'     => $message,
            'data'        => $data,
            'meta'        => [
                'name'       => 'JSON API 4 alarm clock',
                'copyright'  => '4 alarm clock',
                'powered-by' => '四点闹钟',
                'version'    => '1.0'
            ]
        ]);
    }

}