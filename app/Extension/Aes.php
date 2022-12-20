<?php

namespace App\Extension;

/**
 * aes 加密 解密类库
 * Class Aes
 * @package App\Extension
 */
class Aes
{
    private static $key = "12344321";

    private static $iv = "";

    /**
     * 加密
     * @param $string
     * @param string $method AES-128-CBC  DES-ECB
     * @return string
     */
    public static function encrypt($string, $method = "AES-128-ECB")
    {
        $data = openssl_encrypt($string, $method, self::$key, OPENSSL_RAW_DATA);
        return strtolower(bin2hex($data));
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public static function decrypt($string, $method = "AES-128-ECB")
    {
        return openssl_decrypt(hex2bin($string), $method, self::$key, OPENSSL_RAW_DATA);
    }

}
