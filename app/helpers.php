<?php
/*
|--------------------------------------------------------------------------
| 公共方法
|--------------------------------------------------------------------------
|
*/

use App\Models\TaskIncrement as TaskIncrementModel;
use Cisco\Aliyunsms\Facades\Aliyunsms;
use Illuminate\Config\Repository;

define('__COLOR__', [
    'default' => '#b3b9bf',
    'success' => '#21b978',
    'warning' => '#FFB800',
    'normal' => '#1E9FFF',
    'error' => '#DC143C'
]);


/**
 * 商家验证码
 * @param int $length
 * @param string $key
 * @return string
 */
function share_code($length = 5, $key = "m")
{
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern{mt_rand(0, 35)}; //生成php随机数
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
 * @return string
 */
function taskUniqidString()
{
    return time() . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 唯一订单号
 * @return string
 */
function uniqidString()
{
    return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 任务增值
 * @return array
 */
function taskIncrement()
{
    return array_column(TaskIncrementModel::findAll([], ['title', 'key', 'value'], 'id', 'asc')->toArray(), 'value', 'key');
}

/**
 * 任务类型
 * @return array
 */
function taskType()
{
    return array_column(\App\Models\TaskType::findAll([], ['id', 'name', 'image', 'price', 'type'], 'id', 'asc')->toArray(), 'name', 'id');
}

/**
 * @param string $str
 * @param $id
 * @param string $link
 * @return string
 */
function line($str, $id, $link = "-")
{
    return $str == "" ? $id : $str . $link . $id;
}

/**
 * @param $number
 * @return float
 */
function percent($number)
{
    return floatval($number / 100);
}

/**
 * @param $message
 * @param $param
 * @return string
 */
function sprintMessageParam($message, $param)
{
    return sprintf($message, $param[0] ?? "", $param[1] ?? "", $param[2] ?? "", $param[3] ?? "");
}

/**
 * @return false|string
 */
function getDay()
{
    return date('Y-m-d');
}

/**
 * @return false|string
 */
function getWeek()
{
    return date('Y-W');
}

/**
 * @return false|string
 */
function getMonth()
{
    return date('Y-m');
}
