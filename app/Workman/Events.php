<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/9/10 16:57
 * Email: zguangjian@outlook.com
 */

namespace App\Workman;


class Events
{
    public static function onWorkerStart($businessWorker)
    {
        echo "WorkerStart\n";
    }

    public static function onConnect($client_id)
    {
        echo "onConnect\n";
    }

    public static function onWebSocketConnect($client_id, $data)
    {
        echo "onWebSocketConnect\n";
    }

    public static function onMessage($client_id, $message)
    {
        echo "onMessage\n";
    }

    public static function onClose($client_id)
    {
        echo "onClose\n";
    }
}
