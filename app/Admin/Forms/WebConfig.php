<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Tymon\JWTAuth\JWT;

class WebConfig extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        admin_setting($input);
        return $this
            ->response()
            ->success('Processed successfully.')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('webName', '网站名称')->required();
        $this->url('webUrl', '网站地址');
        $this->image('webLogo', '网站Logo')->maxSize(512)->accept('jpg,png,gif,jpeg')->autoUpload()->help("上传文件不能超过512KB");
        $this->radio('webStatus', '网站状态')->options([1 => '开启', 0 => '关闭']);
        $this->radio('webStyle', '网站风格')->options(['简约', '扁平']);
        $this->text('webKeywords', '关键字')->help("关键字之间请使用英文,号隔开");
        $this->textarea('webDescription', '描述');
        $this->confirm("您确定要提交设置吗？", "部分设置提交之后需要重启刷新一下浏览器才能生效");
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'webName' => admin_setting('webName', ''),
            'webUrl' => admin_setting('webUrl', ''),
            'webLogo' => admin_setting('webLogo', ''),
            'webStatus' => admin_setting('webStatus', 1),
            'webStyle' => admin_setting('webStyle', 0),
            'webKeywords' => admin_setting('webKeywords', ''),
            'webDescription' => admin_setting('webDescription', ''),
        ];
    }
}
