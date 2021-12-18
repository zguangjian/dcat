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
    /**
     * @param array $param
     * @param array $rule
     * @param array $message
     * @return array|bool
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

    /**
     * @param array $param
     * @param array $rule
     * @param array $message
     * @return array|int
     * @throws AjaxException
     */
    public static function extract($param = [], $rule = [], $message = [])
    {
        $validate = Validator::make($param, $rule, $message);
        if ($validate->fails()) {
            throw new AjaxException($validate->errors()->first());
        }
        return extract($param);
    }
}
