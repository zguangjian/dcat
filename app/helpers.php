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
    $SignName = "阿里云短信测试专用";          //模板签名
    $send = Aliyunsms::sendSms(strval($phone), $SignName, $template, $param);
    dd($send);
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
 * @param $file
 * @return Repository|mixed
 */
function ossFile($file)
{
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
    $number = sprintf("%0" . $length . "f", is_numeric($number) ? $number : 0);;
    return substr($number, 0, stripos($number, '.') + 1 + $length);
}
