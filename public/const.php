<?php
//上传文件指定目录
define("__YMD_DIR__", date("Y/m/d"));
define("__IMAGE__MOVE__", implode('/', ["images", date("Y"), date("m"), date("d")]));
define("__FILE_MOVE__", implode('/', ["images", date("Y"), date("m"), date("d")]));
//文件所在文件夹
define("__FILE_HOST__", ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . "/storage/");

