<?php
/** 项目设置的 */
define("project_key", "HGVTKI6XTS0VEXCS");
define("project_url", "www.guangjian.site/project/verify");
/** AES */
define('aes_key', 'zhgerXHBVaaKm8xy');
define('aes_method', 'AES-128-ECB');
define('aes_iv', '');

/** 基本 */

define('base_host', $_SERVER["SERVER_NAME"]);
define('base_ip', gethostbyaddr(gethostbyname($_SERVER["SERVER_NAME"])));
define('base_time', time());
define('base_delay', 60);

/** 项目开发 */
define("project_exploit", "");
define("project_exploit_phone", "17314921593");
define("project_exploit_email", "zguangjian@outlook.com");

if (isset($_POST['__browser']) && $_SERVER['PHP_SELF'] === "/auth.php") {
    file_put_contents("auth.config", $_POST['__browser']);
    echo json_encode([
        "code" => 200,
        "msg" => "操作成功"
    ]);
    die;
} else {

    if (file_exists("./auth.config")) {
        $config = file_get_contents("./auth.config");
        $config = openssl_decrypt(base64_decode($config), aes_method, aes_key, OPENSSL_RAW_DATA, aes_iv);
        if ($config === false) return err();
        $config = json_decode($config, true);

        if ($config['ip'] != base_ip || $config['host'] != base_host || strtotime($config['end_time']) < time() || token($config) != $config['token']) {
            return err();
        }

        if (base_time - $config['time'] > base_delay) {
            try {
                $res = curl(project_url, ["data" => file_get_contents("./auth.config")], "post");
                $res = json_decode($res, true);
                if ($res["code"] == 200) {
                    file_put_contents("auth.config", $res["data"]);
                } else {
                    $config['time'] = time();
                    $config['token'] = token($config);
                    $data = openssl_encrypt(json_encode($config), aes_method, aes_key, OPENSSL_RAW_DATA, aes_iv);
                    file_put_contents("auth.config", base64_encode($data));
                }
                return;

            } catch (Exception $exception) {
                $config['time'] = time();
                $config['token'] = token($config);
                $data = openssl_encrypt(json_encode($config), aes_method, aes_key, OPENSSL_RAW_DATA, aes_iv);
                file_put_contents("auth.config", base64_encode($data));
            }
        }
        return;
    } else {
        echo '参数错误';
        die;
    }
}

return;

function token($data)
{
    return strtoupper(md5(($data['ip'] . $data['host'] . $data['time']) . project_key));
}

function err()
{
    echo '
        <div style="text-align:center;color:red;margin-top:20%;">网站配置信息错误请联系网站开发人员</div>
        <div style="text-align:center;color:red;">邮箱：zguangjian@outlook.com</div>
        ';
    die;
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

function getServerIp()
{
    if (isset($_SERVER)) {
        if ($_SERVER['SERVER_ADDR']) {
            $server_ip = $_SERVER['SERVER_ADDR'];
        } else {
            $server_ip = $_SERVER['LOCAL_ADDR'];
        }
    } else {
        $server_ip = getenv('SERVER_ADDR');
    }
    if ($server_ip == '::1') {
        //本地
        $server_ip = '127.0.0.1';
    }
    return $server_ip;
}










