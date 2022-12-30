<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2022/10/9 10:28
 * Email: zguangjian@outlook.com
 * 加密 php encipher.php app app
 * 解密 php encipher.php app app  1
 */
/**
 * 参数
 */
const c = [
    '_sourceFile' => '',
    '_targetFile' => '',
    '_writeContent' => '',
    '_comments' => [
        'Author: zguangjian',
        'Phone: 17314921593',
        'Email: zguangjian@outlook.com'
    ],
    'init' => [
        'q1' => 'O10O0O',
        'q2' => 'O02000',
        'q3' => 'O0O300',
        'q4' => 'OO0O40',
        'q5' => 'OO0005',
        'q6' => 'O6O000',


    ]
];
const f = "%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A";
//根据这个判断是否加密了
const q1 = '$' . c['init']['q1'];
const q2 = '$' . c['init']['q2'];


array_shift($argv);
$dir = array_shift($argv);
$to_dir = array_shift($argv);
$action = array_shift($argv) ? 'decode' : 'encode';

if ($dir && $to_dir) {
    $list = readFolderFiles($dir);
    foreach ($list as $file) {
        try {
            $action == 'encode' ? encodeText($file, targetFile($file, $to_dir)) : decodeText($file, targetFile($file, $to_dir));
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
    die;
}

die("请检查加密文件夹和加密输入文件夹");


/*-----------------------------------------------------------*/
/**
 * 读取文件
 * @param $path
 * @return array
 */
function readFolderFiles($path)
{
    $list = [];
    $resource = opendir($path);
    while ($file = readdir($resource)) {
        //排除根目录
        if ($file != ".." && $file != ".") {
            if (is_dir($path . "/" . $file)) {
                //子文件夹，进行递归
                $list = array_merge($list, readFolderFiles($path . "/" . $file));
            } else {
                //根目录下的文件
                if (substr($file, strpos($file, '.') + 1) == "php") {
                    $list[] = $path . "/" . $file;
                }

            }
        }
    }
    closedir($resource);
    return $list ? $list : [];
}

/**
 * 新文件地址
 * @param $sourceFile
 * @param $toDir
 * @return string
 */
function targetFile($sourceFile, $toDir)
{
    $symbol = '\\';
    if (stristr(php_uname(), "windows")) {
        $symbol = '/';
    }
    $sourceFile = explode($symbol, $sourceFile);
    $sourceFile[0] = $toDir;
    return implode($symbol, $sourceFile);
}

/**
 * 根据文件获取文件夹
 * @param $sourceFile
 * @return false|string
 */
function getFileDir($sourceFile)
{
    $symbol = '\\';
    if (stristr(php_uname(), "windows")) {
        $symbol = '/';
    }

    return substr($sourceFile, 0, strripos($sourceFile, $symbol, 0) + 1);
}

/**
 * 生成随机字符串
 * @return string
 */
function createRandKey()
{
    return str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
}

/**
 * 写入文件
 * @param $targetFile
 * @param $writeContent
 * @return bool
 */
function write($targetFile, $writeContent)
{
    if (!is_dir(getFileDir($targetFile))) {
        mkdir(getFileDir($targetFile), 0777, true);
    }

    $file = fopen($targetFile, 'w');

    fwrite($file, $writeContent) or die('写文件错误');
    fclose($file);

    echo "写入文件" . $targetFile . " 成功" . PHP_EOL;
    return true;
}

/**
 * 加密
 * @param $sourceFile
 * @param $targetFile
 * @return mixed
 */
function encodeText($sourceFile, $targetFile)
{
    //随机密匙1
    $k1 = createRandKey();
    //随机密匙2
    $k2 = createRandKey();
    // 获取源文件内容
    $sourceContent = file_get_contents($sourceFile);

    if (substr_count($sourceContent, q1) > 0 && substr_count($sourceContent, q2) > 0) { //文件中存在f 则不进行加密
        return false;
    }
    $sourceContent = str_replace('declare (strict_types=1);',' ',$sourceContent);
    //base64加密
    $base64 = base64_encode($sourceContent);

    //根据密匙替换对应字符。
    $c = $k1 . $k2 . strtr($base64, $k1, $k2);;
    $config = c;
    $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = "";
    extract($config['init']);
    $encodeContent = '$' . $q6 . '=urldecode("' . f . '");$' . $q1 . '=$' . $q6 . '[3].$' . $q6 . '[6].$' . $q6 . '[33].$' . $q6 . '[30];$' . $q3 . '=$' . $q6 . '[33].$' . $q6 . '[10].$' . $q6 . '[24].$' . $q6 . '[10].$' . $q6 . '[24];$' . $q4 . '=$' . $q3 . '[0].$' . $q6 . '[18].$' . $q6 . '[3].$' . $q3 . '[0].$' . $q3 . '[1].$' . $q6 . '[24];$' . $q5 . '=$' . $q6 . '[7].$' . $q6 . '[13];$' . $q1 . '.=$' . $q6 . '[22].$' . $q6 . '[36].$' . $q6 . '[29].$' . $q6 . '[26].$' . $q6 . '[30].$' . $q6 . '[32].$' . $q6 . '[35].$' . $q6 . '[26].$' . $q6 . '[30];eval($' . $q1 . '("' . base64_encode('$' . $q2 . '="' . $c . '";eval(\'?>\'.$' . $q1 . '($' . $q3 . '($' . $q4 . '($' . $q2 . ',$' . $q5 . '*2),$' . $q4 . '($' . $q2 . ',$' . $q5 . ',$' . $q5 . '),$' . $q4 . '($' . $q2 . ',0,$' . $q5 . '))));') . '"));';
    $headers = array_map('trim', array_merge(array('/*'), $config['_comments'], array('*/')));
    $_writeContent = "<?php" . "\r\n" . implode("\r\n", $headers) . "\r\n" . $encodeContent . "\r\n" . "?>";

    return write($targetFile, $_writeContent);
}

/**
 * 解密
 * @param $sourceFile
 * @param $targetFile
 * @return mixed
 */
function decodeText($sourceFile, $targetFile)
{
    $config = c;
    $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = "";
    extract($config['init']);
    $sourceFiles = $sourceFile;
    $sourceFile = file_get_contents($sourceFile);
    if (substr_count($sourceFile, q1) == 0 && substr_count($sourceFile, q2) == 0) { //文件中不存在f 则不进行解密
        return false;
    }

    //以eval为标志 截取为数组，前半部分为密文中的替换掉的函数名，后半部分为密文
    $m = explode('eval', $sourceFile);

    //对系统函数的替换部分进行执行，得到系统变量
    $varStr = substr($m[0], strpos($m[0], '$'));

    //执行后，后续就可以使用替换后的系统函数名
    eval($varStr);

    //判断是否有密文
    if (!isset($m[1])) {
        return $sourceFile;
    }

    //对密文进行截取 {$q4}  substr
    $star = strripos($m[1], '(');
    $end = strpos($m[1], ')');

    $str = ${$q4}($m[1], $star, $end);

    //对密文解密 {$q1}  base64_decode
    $str = ${$q1}($str);

    //截取出解密后的  核心密文
    $evallen = strpos($str, 'eval');

    $str = substr($str, 0, $evallen);
    //执行核心密文 使系统变量被赋予值 $O0O000
    eval($str);
    $_writeContent = $$q1(
        $$q3(
            $$q4(
                $$q2, $$q5 * 2
            ),
            $$q4(
                $$q2, $$q5, $$q5
            ),
            $$q4(
                $$q2, 0, $$q5
            )
        )
    );

    return write($targetFile, $_writeContent);
}











