<?php

namespace App\Extension;

use phpDocumentor\Reflection\Types\Self_;

/**
 * aes 加密 解密类库
 * Class Aes
 * @package App\Extension
 */
class Aes
{
    private static $key = "1111111111111111";

    private static $method = "AES-128-CBC";

    private static $iv = "1111111111111111";
    // private static $iv = "zhgerXHBVaaKm8xy";

    /**
     * 加密
     * @param $string
     * @param string $method AES-128-CBC  DES-ECB DES-CBC DES-CTR DES-OFB DES-CFB
     * @return string
     */
    public static function encrypt($string, $method = "")
    {
        $data = openssl_encrypt($string, $method ?: self::$method, self::$key, OPENSSL_RAW_DATA, self::$iv);
        return base64_encode($data);
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public static function decrypt($string, $method = "")
    {
        return openssl_decrypt(base64_decode($string), $method ?: self::$method, self::$key, OPENSSL_RAW_DATA, self::$iv);
    }

}
