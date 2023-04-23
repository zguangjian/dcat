<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2023/3/5 15:12
 * Email: zguangjian@outlook.com
 */

namespace App\Extension;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Yansongda\Pay\Exceptions\InvalidArgumentException;
use Yansongda\Pay\Exceptions\InvalidConfigException;
use Yansongda\Pay\Exceptions\InvalidSignException;
use Yansongda\Supports\Collection;

/**
 * Class Pay
 * @package App\Extension
 * @method static Pay  alipay()
 * @method static Pay  wechat()
 */
class Pay
{
    protected $method = "";
    protected $pay;

    public static $payType = [
        1 => "支付宝PC",
        2 => "支付宝WAP",
        3 => "微信二维码",
        4 => "微信WAP",
        5 => "微信MP"
    ];
    protected $config = [
        'alipay' => [
            'app_id' => '2021003128666244',
            //'app_id' => '2018092761556576',
            'notify_url' => 'https://cesuan.1tao.com.cn/callback/alipay',
            'return_url' => 'https://cesuan.1tao.com.cn/#/pages/index/payBack',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjUCvlprFVfPbpffrNRH7bcgegM/4az/QXTAVvrtWzwby41+d8Zp6biaV7Y3QjBFqzvo4nc3qWpNX+P+tuvEV8T1lvVI9HYRFJXPE5C+hNeiJipZdw5QLif+XKNjQ7uHGA/YNDchOHt4CeDNo5H0tlDmro+z8GwueC0+Ym21oWnnsVIu8meWKavNtzCv/qI2IucThUtoMbn0Lrx0jCIbQSiwOHszratrsK6XXG6lR72S5uSwQYLL8ALd1J5Ca/XzuKk4GmaCK9tZnaXAm6Nz9/lCQAyqtPZ9QOKy7Wa7r2JSnw5oXh5YIXD6SR3+iCBj7NFgwpIesY11eq4Kv5fYAHQIDAQAB',
            //'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAog+8+bVc2co6r6YX7n3vhcri0vkuoQ/DbamOOZ1Ny3yE7BnSMrET/NbpqhM00eahjBXm8BGKg7KpOz5KpwvHAd+yBbzCwQSS4pePSTOMA0RnrI8ucMRvwNn0e2DQlbKLChh2HKC4O/ds0uls8B+AlIUwc31ai/ccQThQCZjeD1C2WA472EIUKBFPcHsufVhel/ACc7jpf+TWOPVT0+9IcDNSWROQNNzG0pH9OjX0dy8vHcZhCeD8MT33IOXHxtGsFiy9TjUE53sgil2jeGbtWLuBdAAKG0QtzmV6dGv1+hoygJSINZDl0nu9+gCVuUc+qWyxEXOo5ySMfmffROm5NwIDAQAB',
            // 加密方式： **RSA2**
            'private_key' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC49NNvnwEegxAs6uEmb7xMJMUcrOgrAYHu5cusdQ+8FPSN6LmsApgvwRy0zag546dqaVn9l9Zy17Q1doHMXjR/6ty1n+1WCRDz3sbNwK3+iPPgswi2USY5PNrJyvjtXacC2S2jsbb+x1t7NT+0Ipce0YBvE7NQhDaxJHFTPRt6gN1hL1T/nHszKoQk0/nF7AzjaWsLrGXmlx9cFJWVThuuc7STs/mkCXzlqX/NZX8LMhmw7BnGrmiZbtm5itZmjqHItkqsRYLK7pXztL3937XjJykVRhK2vHwmxM768naVD8HTRvMCyuRUp0z5TgOD0ZWjUk2djSuHlbtWmxi9bSVRAgMBAAECggEAWf2NLp8vvTfJ1AEIQVpWRLoTSet7HwmhvaoDWkquuDV989oLFP1CLOIJ5JK3ykrQ9z6BMZkCF2iKXwTlDJm9c4vDjX9dy+GnZPC8y/l27wSVnHufvo1nSqwoS8y9J0jM7N7cjOv3/KjlAuKatzupSa5njiQIuCFMNw5jMTvnNcfO9QF3Pjcn6jnZHXVblCnvNixrdpcZ/xKIda7glSGWgRB41Utgj9E6QZFsOH0Ypie0jKVwomj0SA+5RzLolrirGQLwNRkVKotP81kyEVPIZJvSjo5kwLw2Ur3aRJktqKMNP34jXul1MNtXklPMowsNrvR+gtsNXwFWBEZ+c6L0DQKBgQDsakEJmqS9wDqTkx48zNkA3pp7fpkXZ7pzY07RKFXiRvVdzoZNsFbTzrwnZy544MEoDqFhTHB9aoOQhL4F+8hB9CEtgDU3/cDG2AdZDXeujLYQqq3XrB4Dm1kFsgGRbw1RwKgv0Epm8GsrVF7eah9Yv1OYOUZUaqAEumEaKNgPOwKBgQDIR0Rjd0kEm/S86Y1lOheGFLk2xT7IkLJducmUIIW19XmefUZaHAB8myonWtQEchlx/QdDoEaE/5Fdn3qxn5E4V22g9xkpUXdcXJPL7C03GF1mh3kYHfvS9dPPPQPrlKaJxm+hD3GIPD3MQeS5cxIAkMWK/8wiFuSKXoAf0RSs4wKBgEA0IvF+w9qcR8woGgAdCZnI2l9LZDwM+X+4qoD22UwYRS5yldqnVw0yibqRtPcy4oIEZyNLZQlKUex/gDOTyzDOIex/cvR/v0jBBk3S8HvAzvj7wTZfEc+c8rIvQ2nBpPZcwdAqWupVxGUCBrmUTGsHmqYud8EZK9fc3d4C1ZpdAoGBAK1vUeDU3q2YJIMnuWNswAxDi/TLMMhczaluhwq4czIUhqJiF/dWgnFlqUZ1WF8VM8XLeWvtssPf0VGDFqwU45wn0e7vrKFkQ/n+zZptRuaMOe3c6VeiN34Dlc3EJ83tZ56t8eNGzWlNybJFab3S0UceF4N8apkmu/i7RzbGR6JDAoGBAMhs1jGPwJ83r5UyK51jcRygIz2uG+Mqof/N73V8oJZ3Hy3GI0JR2htslv7Pt22aCjsLzrQa7JxbV/VDv9QMYOr5pfs81LKE0ph2U3w76fntEuaByk/pWv1GEmMEji7snntC7dMRmXX4RPIj2LejRahbr8LdIk1QXL0DXhcX/44j',
            //'private_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjUCvlprFVfPbpffrNRH7bcgegM/4az/QXTAVvrtWzwby41+d8Zp6biaV7Y3QjBFqzvo4nc3qWpNX+P+tuvEV8T1lvVI9HYRFJXPE5C+hNeiJipZdw5QLif+XKNjQ7uHGA/YNDchOHt4CeDNo5H0tlDmro+z8GwueC0+Ym21oWnnsVIu8meWKavNtzCv/qI2IucThUtoMbn0Lrx0jCIbQSiwOHszratrsK6XXG6lR72S5uSwQYLL8ALd1J5Ca/XzuKk4GmaCK9tZnaXAm6Nz9/lCQAyqtPZ9QOKy7Wa7r2JSnw5oXh5YIXD6SR3+iCBj7NFgwpIesY11eq4Kv5fYAHQIDAQAB',

            'log' => [ // optional
                'file' => './logs/alipay.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            //'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ],
        'wechat' => [
            'app_id' => 'wxa4a587408ccc69a4', // 公众号 APPID
            'mch_id' => '1625511251',
            'key' => '8934e7d15453e97507ef794cf7b0519a',
            'notify_url' => 'https://cesuan.1tao.com.cn/callback/wechat',
            'log' => [ // optional
                'file' => './logs/wechat.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'daily', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
        ],
        'logger' => [ // optional
            'enable' => false,
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ]
    ];

    /**
     * Pay constructor.
     * @param string $method
     */
    public function __construct(string $method = "alipay")
    {
        $this->method = $method;
        if ($this->method == "alipay") {
            $this->pay = \Yansongda\Pay\Pay::alipay($this->config["alipay"]);
        } else {
            $this->pay = \Yansongda\Pay\Pay::wechat($this->config["wechat"]);
        }

    }

    /**
     * @param $name
     * @param $arguments
     * @return Pay
     */
    public static function __callStatic($name, $arguments)
    {
        return new self($name);
    }

    /**
     * WAP端
     * @param $order
     * @param string $openid
     * @return string|RedirectResponse|Collection
     */
    public function wap($order, string $openid = "")
    {
        if ($this->method == "alipay") {
            return $this->pay->wap($order);
        } else {
            if ($openid === "") {
                return $this->pay->wap($order)->getTargetUrl();
            } else {
                $order["openid"] = $openid;
                return $this->pay->mp($order);
            }
        }
    }

    /**
     * PC端
     * @param $order
     * @return mixed
     */
    public function web($order)
    {
        return $this->pay->web($order);
    }

    /**
     * 二维码
     * @param $order
     * @return Collection
     */
    public function scan($order): Collection
    {
        return $this->pay->scan($order);
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidSignException|InvalidConfigException
     */
    public function callback(): Collection
    {
        try {
            $data = $this->pay->verify();
            file_put_contents('notify.txt', '订单号：' . $data['out_trade_no'] . "\r\n", FILE_APPEND);
        } catch (Throwable $exception) {
            file_put_contents('notify.txt', 'date:' . date('Y-m-d H:i:s') . $exception->getMessage() . PHP_EOL, FILE_APPEND);
        }
        return $data;
    }
}
