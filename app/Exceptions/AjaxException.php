<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/26 17:12
 * Email: zguangjian@outlook.com
 */

namespace App\Exceptions;


use Exception;
use Illuminate\Http\Client\Response;
use Throwable;

class AjaxException extends Exception
{
    public function __construct($message = "", $code = 501, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
