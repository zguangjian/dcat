<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'oss'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
        // 这里是新增
        'oss' => [
            'driver' => 'oss',
            'access_id' => 'YOf6D4Fjdk8boU5L', // 这里是你的 OSS 的 accessId,
            'access_key' => "7WAjUNmsNVKD2Y97l2RZmfRgyV0xNM", // 这里是你的 OSS 的 accessKey,
            'bucket' => 'shuadan2021', // 这里是你的 OSS 自定义的存储空间名称,
            'endpoint' => 'img.32301.com', // 这里以杭州为例
            'cdnDomain' => "img.32301.com/", // 使用 cdn 时才需要写, https://加上 Bucket 域名
            'ssl' => false, // true 使用 'https://' false 使用 'http://'. 默认 false,
            'isCName' => true, // 是否使用自定义域名，true: Storage.url() 会使用自定义的 cdn 或域名生成文件 url，false: 使用外部节点生成url
            'debug' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
