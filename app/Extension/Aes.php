<?php

namespace App\Extension;

/**
 * aes 加密 解密类库
 * Class Aes
 * @package App\Extension
 */
class Aes
{
    private static $key = "zhgerXHBVaaKm8xy";

    private static $method = "AES-128-ECB";

    //private static $iv = "7i2m502gj489joml";
    private static $iv = "";

    /**
     * 加密
     * @param $string
     * @param string $method AES-128-CBC  DES-ECB DES-CBC DES-CTR DES-OFB DES-CFB
     * @return string
     */
    public static function encrypt($string, string $method = ""): string
    {
        $data = openssl_encrypt($string, $method ?: self::$method, self::$key, OPENSSL_RAW_DATA, self::$iv);
        return base64_encode($data);
    }

    /**
     * 解密
     * @param String $string input 解密的字符串
     * @param String $method key   解密的 key
     * @return String
     */
    public static function decrypt(string $string, string $method = ""): string
    {
        return openssl_decrypt(base64_decode($string), $method ?: self::$method, self::$key, OPENSSL_RAW_DATA, self::$iv);
    }

}
