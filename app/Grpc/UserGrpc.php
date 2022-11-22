<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2022/11/21 15:39
 * Email: zguangjian@outlook.com
 */

namespace App\Grpc;


use Grpc\BaseStub;

class UserGrpc extends BaseStub
{
    /**
     * UserGrpc constructor.
     * @param $hostname
     * @param $opts
     * @param null $channel
     * @throws \Exception
     */
    public function __construct($hostname, $opts, $channel = null)
    {
        parent::__construct($hostname, $opts, $channel);
    }

    public function userList(\listReq $request, $data = [], $options = [])
    {
        return $this->_simpleRequest(
            "UserProto/List",
            $request,
            [
                \ListRes::class, 'decode'
            ], $data, $options
        );
    }


}
