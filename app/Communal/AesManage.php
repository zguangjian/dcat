<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/27 15:05
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;


class AesManage
{
    /**
     * AES加密、解密类
     * 用法：
     * <pre>
     * // 实例化类
     * // 参数$_bit：格式，支持256、192、128，默认为128字节的
     * // 参数$_type：加密/解密方式，支持cfb、cbc、nofb、ofb、stream、ecb，默认为ecb
     * // 参数$_key：密钥，默认为 _Mikkle_AES_Key_
     * $tcaes = new TCAES();
     * $string = 'laohu';
     * // 加密
     * $encodeString = $tcaes->encode($string);
     * // 解密
     * $decodeString = $tcaes->decode($encodeString);
     * </pre>
     */

    private $_bit = MCRYPT_RIJNDAEL_128;
    private $_type = MCRYPT_MODE_CBC;
    private $_key = '1257638767645634'; // 密钥 必须16位 24位
    private $_use_base64 = true;
    private $_iv_size = null;
    private $_iv = '1257z45667kd56q4';

    public $private_key = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC5gH0PGaC1LlOfB2ytAUxZfruvKgh6tOwMKJDqdcpRPbKaB2JYqfeMadnvIunLEQquSJivWD3HqmEhvmbKhUR2nl5jlCQVFA8gzhuy6nsfqMeOCq3C/dM4aSIYQ0GCtnmFbOuV24wOeeZ/HUMDnF/q6/0Y/yO9R7qII1lf3pF1auXnpDgw/7+52tsgHP138oLss+tWB1IxZ8rgR1Ffol3ML4s9cIstqI9iYx4MIhCrAqiFYHv7OXivjFs2T4XTqvwmFtgkuztgY0cerdxjmFMa/R/sbwnc+HSo0BCZn2Urt54bmyirO8Tv+Ldkj5r7aNgO7u5LHSLnGkhK80GIW0s5AgMBAAECggEAIiwqXaLB+T6MhwpOGdzYXNA88PrUTw6PQXojoB2M5MRx53AezOiawtIpJKWQ3ijIh+y1u++MigC4Hgg+VWaRgyyPhNaggwWL9+YgMiiCAAYOpPsQoZAy3fx4HHIfWl4VKuAy0gt81JnePWJ9mueuv88zc+xkgBT7puKkL0YIE9IJl2FhzyemaARaf9Iy+Oeaoef55x7Vk0cGgUC3zw/4F2JyBrRy7MnB255pdfMR3oUYSqr79Hp4n8OnM0PkI8MwvHn/4MnuUYe+0yKc9MV/u7bdjJVZaglBJ73PCEnPd/HLcAeiUjjN2jwPmqUmJEd3+xwvP2LXkVxHxNaf/nCmAQKBgQD27xCaywfkAPNPn8ga/zb+lyiw+HrMdM2AHsVze1nhyVTyRg36VjKRDJB4jYhmpmDcruvbDdayBRH636YsPQSKwwmZyW0ZqiXa5F75MxEKAe7MJOaCdeSyVKV0O2FJvNE4Up9IZPj7vN8KUXvMQYm0FlD41mIaIJpJE7+ByS95QQKBgQDAUAYdP8T6KFafntnciD3piBpyNzIif4ARHdjzoX6Cg2z2XkeUnGnfQ05EHdVmjfkpgJfmQXO3VIftOM3KqEkBioTD0j6Qv80+iPId1SY4+mG9UzrLOib3VvdX8I5OoCxdIy+FvCeD/OH0WToARYKvH3snp9+iSl986ZX+BcSb+QKBgFAnT5N/XeNTr6bj7ZddymMfe9TeAzZEn8P7uQoAOy/AI3O066qbujQ9CNQo1OLFFOHtYZ+sQUltveVaHV10vPmxz3b83A4dncYMpQts2RYPhIz9WVl1nTOJqF8vOygtQxhuMUfVhsBoEVoPEwk9KM6tA8GSDSv/8zTPVTVysZdBAoGAY5OL9u0kAxuL7s6DpArvc9JDT0yBKxe1qic4RL4kEVQXwWGD0tFCiJYDGoYQDzAICZNKE7FkR1L/prc452xHkQK2R+a++pg1n+Gs7AGH7wzGOw+za7NKpdtj6yblqJSLJBap7qdEFrWEEc95ltZnGmJElH3578BuvPD99y/pY5ECgYEAymy066k/UpurqToGZgVJrhQERoBsFYgWVAjeT/YSDsJ1Il9pJIFWsGAd3Isu+Lgb7p8xDwzzejQ2LbCrpVwhGpDg6erB42DC1C8WeplzPfn9uPxYY6lVxUR0IBjqdB/dYHe6t4VVBP+tUmUTRshd+u767Pydp25/YV8Hyc0pr1A=';

    /**
     * @param string $_key 密钥
     * @param string $_iv
     * @param string $private_key
     * @param int $_bit 默认使用128字节
     * @param string $_type 加密解密方式
     * @param boolean $_use_base64 默认使用base64二次加密
     */
    public function __construct($_key = '', $_iv = '', $private_key = '', $_bit = 128, $_type = 'cbc', $_use_base64 = true)
    {
        // 加密字节
        if (192 === $_bit) {
            $this->_bit = MCRYPT_RIJNDAEL_192;
        } elseif (128 === $_bit) {
            $this->_bit = MCRYPT_RIJNDAEL_128;
        } else {
            $this->_bit = MCRYPT_RIJNDAEL_256;
        }
        // 加密方法
        if ('cfb' === $_type) {
            $this->_type = MCRYPT_MODE_CFB;
        } elseif ('cbc' === $_type) {
            $this->_type = MCRYPT_MODE_CBC;
        } elseif ('nofb' === $_type) {
            $this->_type = MCRYPT_MODE_NOFB;
        } elseif ('ofb' === $_type) {
            $this->_type = MCRYPT_MODE_OFB;
        } elseif ('stream' === $_type) {
            $this->_type = MCRYPT_MODE_STREAM;
        } else {
            $this->_type = MCRYPT_MODE_ECB;
        }
        // 密钥
        if (!empty($_key)) {
            $this->_key = $_key;
        }
        //rsa私钥
        if (!empty($private_key)) {
            $this->private_key = $private_key;
        }
        // 是否使用base64
        $this->_use_base64 = $_use_base64;

        $this->_iv_size = @mcrypt_get_iv_size($this->_bit, $this->_type);
        // 密钥
        if (!empty($_iv)) {
            $this->_iv = $_iv;
        }

    }

    /**
     * 加密
     * @param string $string 待加密字符串
     * @param $_key
     * @return string
     *
     * $aes = new AES();
     * $memberInfo=$aes->encode(json_encode($memberInfo));//直接转换成json字符串，客户端再转换成json对象
     */
    public function encode($string, $_key)
    {
        //

        if (MCRYPT_MODE_ECB === $this->_type) {
            $encodeString = @mcrypt_encrypt($this->_bit, $this->_key, $string, $this->_type, $this->_iv);
        } else {
            $encodeString = @mcrypt_encrypt($this->_bit, $_key, $string, $this->_type, $this->_iv);
        }
        if ($this->_use_base64) {
            $encodeString = base64_encode($encodeString);
        }
        return $encodeString;
    }

    /**
     * 解密
     * @param string $string 待解密字符串
     * @return string
     */
    public function decode($string, $_key)
    {
        if ($this->_use_base64) {
            $string = base64_decode($string);
        }
        if (MCRYPT_MODE_ECB === $this->_type) {
            $decodeString = @mcrypt_decrypt($this->_bit, $this->_key, $string, $this->_type, $this->_iv);
        } else {
            $decodeString = @mcrypt_decrypt($this->_bit, $_key, $string, $this->_type, $this->_iv);
        }
        $decodeString = trim($decodeString);
        return $decodeString;
    }

    //将一维数组转换成字符串
    public function arrtostr($string)
    {
        $res = '';
        foreach ($string as $k => $v) {
            $res .= $k . '=' . $v . '&';
        }
        $res = rtrim($res, "&");//去掉最后一个&
        return $res;
    }

    //将2维数组转换成字符串
    public function twoarrtostr($string)
    {
        $res = '';
        foreach ($string as $k => $v) {
            $res .= $k . '=' . $v . '&';
        }
        $res = rtrim($res, "&");//去掉最后一个&
        return $res;
    }
    //将字符串转换成数组
    /* 将一个字符串转变成键值对数组
    * @param    : string str 要处理的字符串 $str ='name=123&sex=1&num=12';
    * @param    : string sp 键值对分隔符
    * @param    : string kv 键值分隔符
    * @return    : array*/
//    public function strtoarr($string,$sp="&",$kv="="){
//        $arr = str_replace(array($kv,$sp),array('"=>"','","'),'array("'.$string.'")');
//        eval("\$arr"." = $arr;");   // 把字符串作为PHP代码执行
//        return $arr;
//    }


    /**----------------------------以下时rsa--------------------
     * @param $data
     * @return string
     */
    //私钥解密
    public function decrypt($data)
    {
        $private_key = "-----BEGIN PRIVATE KEY-----\n" . wordwrap($this->private_key, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
        $decrypted = "";
        $pi_key = openssl_pkey_get_private($private_key);

        //这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        openssl_private_decrypt(base64_decode($data), $decrypted, $pi_key);
        return $decrypted;
    }

}
