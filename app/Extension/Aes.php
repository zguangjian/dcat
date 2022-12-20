<?php

namespace App\Extension;

/**
 * aes 加密 解密类库
 * Class Aes
 * @package App\Extension
 */
class Aes
{
    private static $key = "sgg45747ss223455";

    /**
     * 加密
     * @param $string
     * @return string
     */
    public static function encrypt($string)
    {
        $data = openssl_encrypt($string, 'AES-128-ECB', self::$key, OPENSSL_RAW_DATA);
        return strtolower(bin2hex($data));
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public static  function decrypt($string)
    {
        return openssl_decrypt(hex2bin($string), 'AES-128-ECB', self::$key, OPENSSL_RAW_DATA);
    }

}
