<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/8/31 11:42
 * Email: zguangjian@outlook.com
 */

namespace App\Extension;


use App\Communal\HttpManage;
use App\Communal\ValidatorManage;
use App\Exceptions\AjaxException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadFile
 * @package App\Extension
 * @method static UploadFile  image()
 * @method static UploadFile  video()
 * @method static UploadFile  excel()
 */
class UploadFile
{

    protected $rule = [];

    protected $size = 0;

    /**
     * UploadFile constructor.
     * @param $rule
     * @param $size
     */

    /**
     * @param $name
     * @param $arguments
     * @return UploadFile
     */
    public static function __callStatic($name, $arguments)
    {
        return new UploadFile();
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
                ValidatorManage::make(request()->all(), [
                    'file' => 'max:' . $this->size
                ], [
                    'file.max' => '文件大小不能超过' . $this->size . 'kb'
                ]);
            }
            $filename = sha1(date('YmdHis', time()) . uniqid()) . '.' . $file->getClientOriginalExtension();
            //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
            Storage::disk('oss')->put($filename, file_get_contents($file->getRealPath()));
            return HttpManage::Response([
                'url' => config('filesystems.disks.oss.cdnDomain') . $filename,
                'file' => $filename
            ]);
        }
        throw new AjaxException("上传接口异常", 500);
    }


}
