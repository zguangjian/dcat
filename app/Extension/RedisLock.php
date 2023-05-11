<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2023/4/26 17:05
 * Email: zguangjian@outlook.com
 */

namespace App\Extension;

use App\Exceptions\AjaxException;
use App\Traits\InstanceTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Psr\SimpleCache\InvalidArgumentException;

class RedisLock
{
    use InstanceTrait;

    /**
     * @var Redis
     */
    private $_redis;

    protected $_lockId;

    const expire = 10;

    public function __construct()
    {
        $this->_redis = Redis::connection();
    }

    /**
     * @param string $key 键
     * @param callable $callback 回调函数
     * @param string $errMsg 错误信息
     * @return mixed
     * @throws AjaxException
     * @throws InvalidArgumentException
     */
    public function lock(string $key, callable $callback, string $errMsg = "")
    {
        $value = uniqid();
        $isLocked = $this->_redis->set($key, $value, "ex", self::expire, "nx");
//        $isLocked = $this->_redis->command('set', $key, $value, "EX", self::expire, "NX");
        if ($isLocked) {
            $this->_lockId[$key] = $value;
            try {
                $res = call_user_func($callback);
                $this->unlock($key);
            } catch (\Throwable $e) {
                $this->unlock($key);
                throw new AjaxException($e->getMessage());
            }
            return $res;
        } else {
            throw new AjaxException($errMsg);
        }


    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function unlock(string $key): bool
    {
        if (isset($this->_lockId[$key])) {
            $lockId = $this->_lockId[$key];
            $rid = $this->_redis->get($key);
            if ($lockId == $rid) {
                $this->_redis->del($key);
                return true;
            }
        }
        return false;
    }
}
