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
use Psr\SimpleCache\InvalidArgumentException;
use Redis;

use function Symfony\Component\Translation\t;

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
        $this->_redis = cache()->store("redis");
    }

    /**
     * @param string $key 键
     * @param callable $callback
     * @param string $errMsg
     * @throws InvalidArgumentException
     * @throws RedisException|AjaxException|\RedisException
     */
    public function lock(string $key, callable $callback, string $errMsg = "")
    {
        $value = rand(1, 100000) . rand(1, 100000);

         $isLocked = $this->_redis->set($key, $value, ['nx', 'ex' => self::expire]);
//        $isLocked = $this->_redis->rawCommand('set', $key, $value, "EX", self::expire, "NX");
        if ($isLocked) {
            $this->_lockId[$key] = $value;
            $res = call_user_func($callback);
            $this->unlock($key);
            file_put_contents("lock.txt", "locked:$isLocked" . PHP_EOL, FILE_APPEND);
            return $res;
        } else {
            throw new AjaxException($errMsg);
        }


    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException|RedisException
     */
    public function unlock(string $key): bool
    {
        if (isset($this->_lockId[$key])) {
            $lockId = $this->_lockId[$key];
            $rid = $this->_redis->get($key);
            if ($lockId == $rid) {
                $this->_redis->delete($key);
                Log::info("解除锁成功：" . $key . "!");
                return true;
            }
        }
        return false;
    }
}
