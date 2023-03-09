<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/22 10:26
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;

use App\Extension\Aes;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * http
 * Class HttpManage
 * @package App\Communal
 */
class HttpManage
{
    public $data;

    /**
     * HttpManage constructor.F
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param bool $assoc
     * @return mixed
     */
    public function toArray($assoc = true)
    {
        return json_decode($this->data, $assoc);
    }

    public static function data($data)
    {
        return new HttpManage($data);
    }

    /**
     * curl请求
     * @param $url
     * @param array $params
     * @param string $method
     * @param array $header
     * @param bool $multi
     * @return HttpManage
     * @throws Exception
     */
    public static function curl($url, $params = [], $method = 'GET', $header = [], $multi = false)
    {
        $opts = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $header
        );

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error)
            throw new Exception('请求发生错误：' . $error);
        return self::data($data);
    }


    /**
     * 返回数据类型
     * @param array $data
     * @param int $code
     * @param string $message
     * @param bool $AES
     * @return JsonResponse
     */
    public static function Response($data = [], $code = 200, $message = "ok")
    {
        $time = time();
        $data = env("API_AES", false) === true ? Aes::encrypt(json_encode($data)) : $data;
        return response()->json(compact('data', 'code', 'message', 'time'), $code);

    }
}
