<?php

use Illuminate\Support\Arr;

define('__COLOR__', [
    'default' => '#b3b9bf',
    'success' => '#21b978',
    'warning' => '#FFB800',
    'normal' => '#1E9FFF',
    'error' => '#DC143C'
]);

if (!function_exists('user_admin_config')) {
    function user_admin_config($key = null, $value = null)
    {
        $session = session();

        if (!$config = $session->get('admin.config')) {
            $config = config('admin');

            $config['lang'] = config('app.locale');
        }

        if (is_array($key)) {
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            $session->put('admin.config', $config);

            return;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }
}

/**
 * 商家验证码
 * @param int $length
 * @param string $key
 * @return string
 */
function business_share_code($length = 5, $key = "b")
{
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern[mt_rand(0, 35)]; //生成php随机数
    }
    return $key;
}

/**
 * @param $phone
 * @param $code
 * @return bool
 */
function aliSms($phone, $code)
{
    $SignName = "e流";          //模板签名
    $TemplateCode = "SMS_175490271";         //模板CODE
    $TemplateParam = [
        "code" => $code,
    ];
    $send = Aliyunsms::sendSms(strval($phone), $SignName, $TemplateCode, $TemplateParam);
    if ($send->Code == 'OK') {
        return true;
    } else {
        return false;
    }
}

function sms($phone, $template, $param)
{
    $SignName = "合蒜教育";          //模板签名
    $send = Aliyunsms::sendSms(strval($phone), $SignName, $template, $param);
    if ($send->Code == 'OK') {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $value
 * @return string
 */
function imgUrl($value)
{
    if (request()->header('key')) {
        return $value == "" ? $value : config('filesystems.disks.oss.endpoint') . $value;
    }
    return $value;
}

/**
 * 毫秒
 * @return float
 */
function msectime()
{
    list($msec, $sec) = explode(' ', microtime());
    return sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
}

function getTimeHour($timeDiff = '')
{
    $hour = sprintf('%02s', intval($timeDiff / 3600));
    $minute = sprintf('%02s', intval(($timeDiff - $hour * 3600) / 60));;
    $second = sprintf('%02s', intval($timeDiff - $hour * 3600 - $minute * 60));
    return $hour == 0 ? "" : "$hour :" . $hour == 0 && $minute == 0 ? "" : "$minute:" . $second;
}

/**
 * @param $file
 * @return Repository|mixed
 */
function ossFile($file)
{
    if ($file == null) {
        return "";
    }
    $data = json_decode($file, true);
    if ($data !== null) {
        foreach ($data as &$value) {
            $value = ossFile($value);
        }
        return $data;
    }

    if (strpos($file, config('filesystems.disks.oss.endpoint')) !== false) {
        return $file;
    }
    return "http://" . config('filesystems.disks.oss.endpoint') . (substr($file, 0, 1) != "/" ? "/" . $file : $file);
}

/**唯一任务订单号
 * @param string $type
 * @return string
 */
function uniqueString($type = 'time')
{
    $prefix = "";
    switch ($type) {
        case 'time':
            $prefix = time();
            break;
        case 'date':
            $prefix = date('YmdHis');
            break;
        default;
    }
    return $prefix . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

}


/**
 * 取小数后几位
 * @param $number
 * @param int $length
 * @return false|string
 */
function rounded($number, $length = 2)
{
    $number = sprintf("%0" . $length . "f", is_numeric($number) ? $number : 0);
    return substr($number, 0, stripos($number, '.') + 1 + $length);
}

/**
 * @param $list
 * @param array $select
 * @return mixed
 */
function ossFileList($list, array $select)
{
    foreach ($list as &$item) {
        foreach ($select as $value) {
            $item->$value = ossFile($item->$value);
        }
    }
    return $list;
}

/**
 * 微信开放平台参数
 * @return array
 */
function openWeChatConfig()
{
    return [
        'AppID' => "wx8e23374e487804bd",
        'AppSecret' => "f83f4cbc72f6e8c5ee1208f97a45d835"
    ];
}

/**
 * 支付参数
 * @return array
 */
function payConfig()
{
    return [
        'alipay' => [
            'app_id' => '2018092761556576',
            'notify_url' => 'https://dy.shangxue.com/callback/alipay',
            'return_url' => 'https://dy.shangxue.com/#/pages/index/payBack',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiqC39+58bXE7+/62iPePVy4YG0AXQGn0ACidriUXb+t9lD6wUcR2Vett17ocu99oo/gXPEhhc1MyTAMI743g9Xf4ByRg/qgsRcKNgKjV15XEjugUU0KlDLFt+XTxwJzaSDYbcD5bx2CeeNhaE7xXTXY/J5c7Xv0ZnI8j1GYUJ1B8PwmW/g0bDYyFpRiwnUMJ9XjPEz8h6UK6ee1FkquVWex8VYYa64JGsdDlH1lu2MRY/bfmwb1B0H/BiyD/JUXbYVU+Y2eKItbesQPg338elfbzdf/aPod+GcE+mUlgXCV/hQ/QG9bdBLKZ/T89qNuhUeH66oHbmu0EnrwZ6geIswIDAQAB',
            // 加密方式： **RSA2**
            'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCZ11x18Y14i8nIOfRz9P5zTKwnX+uasoJ29G0vtrWW+IukNcyuG9yNVw3r+jq41MG2hEF4o9jaLbyRXcat/zwKTyiQrpcMF7wCLqGuYDAxHZBUtIDw4RqYmCUTqqdtBBcOlWQwqeN3jP/NlAjIp72+/Dp6ubc2oNHu9t4/Ia6jtJoDC5fuHoyg0EZYC7Az8b/PJgk3NkCevzs14Wh5+m6+e5sazOwCeMRrjFK6VhztDauyBndgWP8dva+wsxpZ3hU56KHKcyW4/3rcdznL+VpXaKj7SVQ2HYqvgEluo0jnUQawovI/5/lnv3PE00yE90C5q/FmuqQ9lPMG7O5vVJGJAgMBAAECggEARWVjnQSQl48fP8X84o3idiphAgX/5rGdroFF+58EvQxzGWj3YpbI360kZ41iDdxTYby5N+1ZNdop1L0jkXuwHspkdxd6pYbTVXypjFpxgsZeRAeEnqQ8dhczqnJxwfh1WivDnTwVkuk0vwyHBdS9ADkRPCkoX2keKhiMWpgcClYKqQ10CxrZfL3JkYskxhZsKChIjzXvYg2LsYzPZqYfdG3cYt+VweHUz7odQV1TXjeL054/35uioX8eYMbDZEi4ywlOxNt3gLTcgYzyOxtxkMBhWF/d4QPehd64PNhF7u2tStNc+QsthM18mbBlPB8T1mDavMxfAyHbFHGxqH2ErQKBgQDbna0yKp2Tw0UKL4XJZm8q1EQ0qiAAHEr8WV95mNVMkghxNOS3V/D1PEWGJVRjU/7EH+esX3O1YoajMQMBtnOq86fu0iDi0QJ0HKZ/wQZ9dzhcIUMWEbaGXbJRuXptXhy/3g6r+g8gX111e6Acq/1FNAVI3XezZ1jFR2TVpRfj+wKBgQCzVA62U5tlTYjTMacSwZoDKrIpjpA7m8H3bbSKHSaR78map8aMr4WcylVvDjv8/Wep7mUcwApbbhz+WaDWOEMrc7kGL6UIvTCrbEPLsu/GMeQqT6cf+T7rOgYHMc7sFRwqsTeceXBbkxBvVXY4dZJa3hn+LDbqFjZgAVHRgOylSwKBgQCQyaBw7YWb8GYo8/HJOP5bhzw8WFjmmcCaJDX8zdT6OWDVeeC8O39Bvu27Jgs/vRW+qaYsj3WShRVsq5hm3aneb+ssWV6TCucKNAVVPqYPu7TtkIRRHXZvmYBBvv3G8wATQsv7d83XMuhD1zBVFtLQeB5vzornPWBaF9qTu9dHVwKBgC9QLy2Fs4svwLjP8d+t+r95JVZ3ibBgcPWiGS8Tb9izJkLKn0UBDkSG0bGiVMtz5ETeZAkI1fK3g6jL5vZ+E6LEPn3WVjmPCOdBgkWdKUvmX+eV6mcyMJqJTYvaZVi+XRcaeKytEarniz+EkdNlmb6luL/p1HdAcwozbu3SkR0vAoGAcdYejTHA545ulI9eih5dUJcl48XKqmqecsTNrfweHx3BzbwVZPOnRCgXfxgVHXasIoPxPFNLcFyqLp3smrRFpJLILwQ7/ljGvzRR/i1KdmYsyj2RqENsbp8bj3vTSsfqdv9tf/En0y0fMhFmuC4+oqKkZUm23GS8oQs+ux4KG2M=',

            'log' => [ // optional
                'file' => './logs/alipay.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            //'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ],
        'wechat' => [
            'app_id' => 'wx59a44486f4117ade', // 公众号 APPID
            'mch_id' => '1496253022',
            'key' => '8934e7d15453e97507ef794cf7b0519a',
            'notify_url' => 'http://123.32301.com/callback/wechat',
            'log' => [ // optional
                'file' => './logs/wechat.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'daily', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
        ],
        'logger' => [ // optional
            'enable' => false,
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
    ];
}
