<?php
/** AES */
define('aes_key', 'zhgerXHBVaaKm8xy');
define('aes_method', 'AES-128-ECB');
define('aes_iv', '');

/** 基本 */
define('base_ip', $_SERVER['REMOTE_ADDR']);
define('base_host', $_SERVER['HTTP_HOST']);
define('base_time', time());
define('base_delay', 60 * 60 * 24);

/** 项目设置的 */
define("project_key", "V6ZEC0PMUGDLDE4V");


if (file_exists("./auth.config")) {
    $config = file_get_contents("./auth.config");
    $config = openssl_decrypt(base64_decode($config), aes_method, aes_key, OPENSSL_RAW_DATA, aes_iv);
    if ($config === false) return err();
    $config = json_decode($config, true);

    if ($config['ip'] != base_ip || $config['host'] != base_host || strtotime($config['end_time']) < time() || token($config) != $config['token']) {
        return err();
    }
    if (base_time - $config['time'] > base_delay) {

    }


} else {
    echo  '参数错误';die;
}


function token($data)
{
    return strtoupper(md5(($data['ip'] . $data['host'] . $data['time']) . project_key));
}

function err()
{

    return 1;
}


function curl($url, $params = [], $method = 'GET', $header = [], $multi = false)
{
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );

    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error)
        throw new Exception('请求发生错误：' . $error);
    return $data;
}

var_dump($config);







