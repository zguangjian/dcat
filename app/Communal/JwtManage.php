<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/26 16:26
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;

use App\Exceptions\AjaxException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Throwable;


/**
 * Class JwtManage
 * @property array refresh_token
 * @package App\Communal
 * @method static JwtManage  business()
 * @method static JwtManage  member()
 */
class JwtManage
{
    /**
     * 密钥
     * @var mixed
     */
    protected $key;

    /**
     * @var
     */
    protected $time;
    /**
     * 签发者 可选
     */
    protected $iss;

    /**
     * 接收该JWT的一方，可选
     * @var
     */
    protected $aud;
    /**
     * 签发时间
     */
    protected $iat;
    /**
     * 某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
     */
    protected $nbf;
    /**
     * 过期时间,这里设置2个小时
     */
    protected $exp;

    /**
     * access-token 有效期
     */
    protected $exp_time = 7200 * 6;
    /**
     * refresh-token 有效期
     * @var float|int
     */
    protected $refresh_time = 86400 * 30;

    /**
     * access-token 数据
     * @var array
     */
    protected $access_token = [];

    /**
     * refresh-token 数据
     * @var array
     */
    protected $refresh_token = [];


    /**
     * 初始化
     * JwtManage constructor.
     * @param $name
     * @param $arguments
     */
    public function __construct($name, $arguments)
    {
        $this->time = time();
        $this->access_token = [
            'iat' => $this->time, //签发时间
            'nbf' => $this->time, //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $this->time + $this->exp_time, //过期时间,这里设置2个小时
        ];

        $this->refresh_token = [
            'iat' => $this->time, //签发时间
            'nbf' => $this->time, //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $this->time + $this->refresh_time, //过期时间,这里设置2个小时
        ];
        $this->key = env('JWT_KEY', 'jwt-123456');
    }

    /**
     * 静态魔术方法
     * @param $name
     * @param $arguments
     * @return JwtManage
     */
    public static function __callStatic($name, $arguments)
    {
        return new JwtManage($name, $arguments);
    }

    /**
     * 加密
     * @param array $params
     * @param string $type
     * @return array
     */
    public function encode(array $params = [], string $type = "bearer"): array
    {
        $this->access_token = array_merge($this->access_token, $params);
        $this->refresh_token = array_merge($this->refresh_token, $params);
        return [
            'access_token' => JWT::encode($this->access_token, $this->key),
            'refresh_token' => JWT::encode($this->refresh_token, $this->key),
            'token_type' => $type
        ];
    }

    /**
     * 解密 抓异常
     * @param $token
     * @return array
     * @throws AjaxException
     */
    public function decode($token): array
    {
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
            return (array)$decoded;
        } catch (SignatureInvalidException $e) {  //签名不正确
            throw new AjaxException($e->getMessage(), 401);
        } catch (BeforeValidException $e) {  // 签名在某个时间点之后才能用
            throw new AjaxException($e->getMessage(), 401);
        } catch (ExpiredException $e) {  // token过期
            throw new AjaxException($e->getMessage(), 401);
        } catch (Throwable $e) {  //其他错误
            throw new AjaxException($e->getMessage(), 401);
        }

    }
}
