<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/12/3 11:03
 * Email: zguangjian@outlook.com
 */

namespace App\Extension;


class RSA
{
    /**
     * @var string
     */
    protected static $PublicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCmkANmC849IOntYQQdSgLvMMGm8V/u838ATHaoZwvweoYyd+/7Wx+bx5bdktJb46YbqS1vz3VRdXsyJIWhpNcmtKhYinwcl83aLtzJeKsznppqMyAIseaKIeAm6tT8uttNkr2zOymL/PbMpByTQeEFlyy1poLBwrol0F4USc+owwIDAQAB";

    /**
     * @var string
     */
    protected static $PrivateKey = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKaQA2YLzj0g6e1hBB1KAu8wwabxX+7zfwBMdqhnC/B6hjJ37/tbH5vHlt2S0lvjphupLW/PdVF1ezIkhaGk1ya0qFiKfByXzdou3Ml4qzOemmozIAix5ooh4Cbq1Py6202SvbM7KYv89sykHJNB4QWXLLWmgsHCuiXQXhRJz6jDAgMBAAECgYAIF5cSriAm+CJlVgFNKvtZg5Tk93UhttLEwPJC3D7IQCuk6A7Qt2yhtOCvgyKVNEotrdp3RCz++CY0GXIkmE2bj7i0fv5vT3kWvO9nImGhTBH6QlFDxc9+p3ukwsonnCshkSV9gmH5NB/yFoH1m8tck2GmBXDj+bBGUoKGWtQ7gQJBANR/jd5ZKf6unLsgpFUS/kNBgUa+EhVg2tfr9OMioWDvMSqzG/sARQ2AbO00ytpkbAKxxKkObPYsn47MWsf5970CQQDIqRiGmCY5QDAaejW4HbOcsSovoxTqu1scGc3Qd6GYvLHujKDoubZdXCVOYQUMEnCD5j7kdNxPbVzdzXll9+p/AkEAu/34iXwCbgEWQWp4V5dNAD0kXGxs3SLpmNpztLn/YR1bNvZry5wKew5hz1zEFX+AGsYgQJu1g/goVJGvwnj/VQJAOe6f9xPsTTEb8jkAU2S323BG1rQFsPNgjY9hnWM8k2U/FbkiJ66eWPvmhWd7Vo3oUBxkYf7fMEtJuXu+JdNarwJAAwJK0YmOLxP4U+gTrj7y/j/feArDqBukSngcDFnAKu1hsc68FJ/vT5iOC6S7YpRJkp8egj5opCcWaTO3GgC5Kg==';

    /**
     * @return string
     */
    public static function getPrivateKey()
    {
        return "-----BEGIN PRIVATE KEY-----\n" . wordwrap(self::$PrivateKey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
    }


    /**
     * @return string
     */
    public static function getPublicKey()
    {
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap(self::$PublicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }

    /**
     * @param string $data
     * @return string
     */
    public static function encrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        };

        $key = openssl_pkey_get_public(self::getPublicKey());
        if (!$key) {
            return null;
        }
        $return_en = openssl_public_encrypt($data, $encrypted, $key);
        return !$return_en ? null : base64_encode($encrypted);
    }

    /**
     * @param string $string
     * @return null
     */
    public static function decrypt($string = '')
    {

        //私钥解密
        $pi_key = openssl_pkey_get_private(self::getPrivateKey());
        //这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        openssl_private_decrypt(base64_decode($string), $decrypted, $pi_key);
        return $decrypted;
    }
}
