<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2023/4/25 19:08
 * Email: zguangjian@outlook.com
 */

namespace App\Traits;

trait InstanceTrait
{
    private static $instances;

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        $className = get_called_class();
        $args = func_get_args();
        //若$args中有resource类型的参数,则无法区分同一个类的不同实例
        $key = md5($className . ':' . serialize($args));
        if (!isset(self::$instances[$key])) {
            //PHP_VERSION >= 5.6.0
            self::$instances[$key] = new $className(...$args);
        }
        return self::$instances[$key];

    }
}
