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
    protected static $PublicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCy3EEurGf5axEDwd3sRqGlNDu2L9auKnkuBIOK7MKFOf6FEyckN13IyLLwS0tX479Go52PxafgRk6UJm+MtcyXh0w8M9MDvaPgYbaUbG4xrhuiXX3wx1MRReqPtzBWIrogboYTc8kXNzmYDyQPYcLrhux87Pt9tv3f8iljzcwGUwIDAQAB";

    /**
     * @var string
     */
    protected static $PrivateKey = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC5gH0PGaC1LlOfB2ytAUxZfruvKgh6tOwMKJDqdcpRPbKaB2JYqfeMadnvIunLEQquSJivWD3HqmEhvmbKhUR2nl5jlCQVFA8gzhuy6nsfqMeOCq3C/dM4aSIYQ0GCtnmFbOuV24wOeeZ/HUMDnF/q6/0Y/yO9R7qII1lf3pF1auXnpDgw/7+52tsgHP138oLss+tWB1IxZ8rgR1Ffol3ML4s9cIstqI9iYx4MIhCrAqiFYHv7OXivjFs2T4XTqvwmFtgkuztgY0cerdxjmFMa/R/sbwnc+HSo0BCZn2Urt54bmyirO8Tv+Ldkj5r7aNgO7u5LHSLnGkhK80GIW0s5AgMBAAECggEAIiwqXaLB+T6MhwpOGdzYXNA88PrUTw6PQXojoB2M5MRx53AezOiawtIpJKWQ3ijIh+y1u++MigC4Hgg+VWaRgyyPhNaggwWL9+YgMiiCAAYOpPsQoZAy3fx4HHIfWl4VKuAy0gt81JnePWJ9mueuv88zc+xkgBT7puKkL0YIE9IJl2FhzyemaARaf9Iy+Oeaoef55x7Vk0cGgUC3zw/4F2JyBrRy7MnB255pdfMR3oUYSqr79Hp4n8OnM0PkI8MwvHn/4MnuUYe+0yKc9MV/u7bdjJVZaglBJ73PCEnPd/HLcAeiUjjN2jwPmqUmJEd3+xwvP2LXkVxHxNaf/nCmAQKBgQD27xCaywfkAPNPn8ga/zb+lyiw+HrMdM2AHsVze1nhyVTyRg36VjKRDJB4jYhmpmDcruvbDdayBRH636YsPQSKwwmZyW0ZqiXa5F75MxEKAe7MJOaCdeSyVKV0O2FJvNE4Up9IZPj7vN8KUXvMQYm0FlD41mIaIJpJE7+ByS95QQKBgQDAUAYdP8T6KFafntnciD3piBpyNzIif4ARHdjzoX6Cg2z2XkeUnGnfQ05EHdVmjfkpgJfmQXO3VIftOM3KqEkBioTD0j6Qv80+iPId1SY4+mG9UzrLOib3VvdX8I5OoCxdIy+FvCeD/OH0WToARYKvH3snp9+iSl986ZX+BcSb+QKBgFAnT5N/XeNTr6bj7ZddymMfe9TeAzZEn8P7uQoAOy/AI3O066qbujQ9CNQo1OLFFOHtYZ+sQUltveVaHV10vPmxz3b83A4dncYMpQts2RYPhIz9WVl1nTOJqF8vOygtQxhuMUfVhsBoEVoPEwk9KM6tA8GSDSv/8zTPVTVysZdBAoGAY5OL9u0kAxuL7s6DpArvc9JDT0yBKxe1qic4RL4kEVQXwWGD0tFCiJYDGoYQDzAICZNKE7FkR1L/prc452xHkQK2R+a++pg1n+Gs7AGH7wzGOw+za7NKpdtj6yblqJSLJBap7qdEFrWEEc95ltZnGmJElH3578BuvPD99y/pY5ECgYEAymy066k/UpurqToGZgVJrhQERoBsFYgWVAjeT/YSDsJ1Il9pJIFWsGAd3Isu+Lgb7p8xDwzzejQ2LbCrpVwhGpDg6erB42DC1C8WeplzPfn9uPxYY6lVxUR0IBjqdB/dYHe6t4VVBP+tUmUTRshd+u767Pydp25/YV8Hyc0pr1A=';

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
        return openssl_public_encrypt($data, $encrypted,self::getPublicKey()) ? base64_encode($encrypted) : "";
    }

    /**
     * @param string $string
     * @return null
     */
    public static function decrypt($string = '')
    {
        $pi_key = openssl_pkey_get_private(self::getPrivateKey());
        //这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        openssl_private_decrypt(base64_decode($string), $decrypted, $pi_key);
        return $decrypted;
    }
}
