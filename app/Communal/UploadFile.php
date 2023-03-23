<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/29 15:35
 * Email: zguangjian@outlook.com
 */

namespace App\Communal;

use App\Exceptions\AjaxException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Class UploadFile
 * @package App\Communal
 * @method static UploadFile  image()
 * @method static UploadFile  video()
 * @method static UploadFile  excel()
 */
class UploadFile
{
    /**
     * @var array
     */
    public static $fileType = [
        "image" => "jpg|jpeg|png|gif",
        "video" => "flv|avi|3gp|mp4",
        "excel" => "xls",
    ];

    protected $rule = [];

    protected $size = 0;

    protected $dir = "";

    protected $disk = "public";

    protected $prefixInfo = [
        "prefix_url" => "",
        "prefix_file" => "",
    ];

    /**
     * UploadFile constructor.
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
        $this->rule = explode("|", self::$fileType[$dir]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return UploadFile
     */
    public static function __callStatic($name, $arguments)
    {
        return new UploadFile($name);
    }

    /**
     * @param $rule
     * @return $this
     */
    public function rule($rule)
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * 设置存储
     * @param string $disk
     * @return $this
     */
    public function driver($disk = "public")
    {
        $this->disk = $disk;
        switch ($this->disk) {
            case "public":
                $this->prefixInfo = [
                    "prefix_url" => __FILE_HOST__,
                    "prefix_file" => '/storage/',
                ];
                break;
            case "oss":
                $this->prefixInfo = [
                    "prefix_url" => config('filesystems.disks.oss.url'),
                    "prefix_file" => '/',
                ];
                break;
            default:
                break;
        }
        return $this;
    }

    /**
     * @param $size
     * @return $this
     */
    public function size($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param UploadedFile $file
     * @return JsonResponse
     * @throws AjaxException
     */
    public function upload(UploadedFile $file)
    {
        if ($file && $file->isValid()) {
            //允许上传文件格式
            if ($file->getClientOriginalName() && !in_array($file->getClientOriginalExtension(), $this->rule)) {
                throw new AjaxException("请上传 " . implode(',', $this->rule) . " 类型文件", 500);
            }
            if ($this->size > 0) {
                $validate = Validator::make(request()->all(), [
                    'file' => 'max:' . $this->size
                ], [
                    'file.max' => '文件大小不能超过' . $this->size . 'kb'
                ]);
                if ($validate->fails()) {
                    throw new  AjaxException($validate->errors()->first(), 500);
                }
            }
            $filename = $this->dir . '/' . __YMD_DIR__ . '/' . sha1(date('YmdHis', time()) . uniqid()) . '.' . $file->getClientOriginalExtension();
            //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
            Storage::disk($this->disk)->put($filename, file_get_contents($file->getRealPath()));
            return HttpManage::Response([
                //'url' => 'http://' . config('filesystems.disks.oss.cdnDomain') . $filename,
                'url' => $this->prefixInfo["prefix_url"] . $filename,
                'file' => $this->prefixInfo["prefix_file"] . $filename
            ]);
        }
        throw new AjaxException("上传接口异常", 500);
    }


}
