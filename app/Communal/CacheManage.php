<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/27 17:07
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;

use Illuminate\Support\Facades\Cache;

/**
 * Class CacheManage
 * @package App\Http\Communal
 * @method static CacheManage user()
 * @method static CacheManage key()
 * @method static CacheManage menu()
 * @method static CacheManage permission()
 * @method static CacheManage role_permission($role_id)
 */
class CacheManage
{
    /**
     * @var
     */
    private $method;
    /**
     * @var
     */
    private $param;


    /**
     * CacheManage constructor.
     * @param $method
     * @param array $param
     */
    public function __construct($method, array $param = [])
    {
        $this->method = $method;
        $this->param = $param;
    }

    /**
     * @param $method
     * @param $param
     * @return CacheManage
     */
    public static function __callStatic($method, $param)
    {
        return new self($method, $param);
    }

    /**
     * @return string
     */
    private function uniqueKey(): string
    {
        return empty($this->param) ? "" : '__' . implode('__', $this->param);
    }

    /**
     * @return string
     */
    private function getCacheKey(): string
    {
        return "Cache__" . $this->method . $this->uniqueKey();
    }

    /**
     * @return mixed
     */
    public function getCacheData()
    {
        return Cache::get(self::getCacheKey());
    }

    /**
     * @param $data
     * @param int $ttl
     * @return mixed
     */
    public function setCacheData($data, $ttl = 0)
    {
        if ($ttl === 0) {
            Cache::forever(self::getCacheKey(), $data);
        } else {
            Cache::put(self::getCacheKey(), $data, $ttl);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function clearData()
    {
        return Cache::forget(self::getCacheKey());
    }
}
