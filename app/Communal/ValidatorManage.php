<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/12/3 18:28
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;


use App\Exceptions\AjaxException;
use Illuminate\Support\Facades\Validator;

class ValidatorManage
{
    public $param;

    public function __construct(array $param = [])
    {
        $this->param = $param;
    }

    public function extract(&$mobile)
    {
        extract($this->param);
    }

    /**
     * @param array $param
     * @param array $rule
     * @param array $message
     * @return array
     * @throws AjaxException
     */
    public static function make($param = [], $rule = [], $message = [])
    {
        $validate = Validator::make($param, $rule, $message);
        if ($validate->fails()) {
            throw new AjaxException($validate->errors()->first());
        }
        return $param;
    }
}
