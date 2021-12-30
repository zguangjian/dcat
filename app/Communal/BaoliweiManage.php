<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/12/29 17:12
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;


class BaoliweiManage
{
    protected static $userid = "f16afdc55a";
    protected static $secretkey = "t4Wsyv0s1U";

    protected static $categoryUri = "http://api.polyv.net/v2/video/%s/cataJson";

    protected static $searchUri = "http://api.polyv.net/v2/video/search-videos";

    /**
     * @param $param
     * @return string
     */
    public static function sign($param)
    {
        ksort($param);
        return strtoupper(sha1(http_build_query($param) . self::$secretkey));
    }

    /**
     * 视频分类
     * @return mixed
     * @throws \Exception
     */
    public static function category()
    {
        $param = [
            'userid' => self::$userid,
            'ptime' => msectime(),
        ];
        $param['sign'] = self::sign($param);
        return HttpManage::curl(sprintf(self::$categoryUri, self::$userid), $param)->toArray();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public static function search($data = [])
    {
        $param = [
            'userid' => self::$userid,
            'ptime' => msectime(),
        ];
        $param = array_merge($param, $data);
        $param['sign'] = self::sign($param);
        return HttpManage::curl(sprintf(self::$searchUri, self::$userid), $param)->toArray();
    }
}