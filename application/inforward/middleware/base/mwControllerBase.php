<?php
/**
 * Created by PhpStorm.
 * User: zico
 * Date: 2018/6/19
 * Time: 上午9:45
 */

namespace app\inforward\middleware\base;

use think\Exception;
use think\facade\Request;

trait mwControllerBase
{
    public $apiList = [];

    /**
     * @param null $method
     * @return bool
     * @throws Exception
     */
    public function validApi($method = null)
    {
        if (in_array($method, $this->apiList) && $method !== null) {
            return true;
        } else {
            throw new Exception('非法访问api接口');
            return false;
        }
    }

    /**
     * standard_response
     * 返回数据标准化接口
     * @param $response
     * @param int $resCode
     * @return \think\response\Json
     */
    public function standardResponse($response, $resCode = 200)
    {
        return json($response)->code($resCode);
    }

    /**
     * getParam
     * 获取单个接口参数
     * @param $key
     * @param null $default
     * @param bool $isMust
     * @return mixed|null
     * @throws Exception
     */
    public function getParam($key, $default = null, $isMust = false)
    {
        if ($isMust && Request::has($key)) {
            return $param = Request::param($key, $default);
        } else {
            throw new Exception("缺少接口参数:" . $key, 404);
            return $default;
        }
    }


}