<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/12/29 16:45
 * Email: zguangjian@outlook.com
 */

namespace App\Admin\Repositories;


use App\Communal\BaoliweiManage;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Repositories\Repository;

class Baoliwei extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = \App\Models\Course::class;

    public function get(Grid\Model $model)
    {
        $data = BaoliweiManage::search($model->filter()->inputs())['data'];
        $totalPages = $data['totalPages'];
        $list = [];
        foreach ($data['contents'] as $val) {
            $list[] = [
                'id' => $val['vid'],
                'title' => $val['basicInfo']['title'],
                'duration' => $val['basicInfo']['duration'],
                'coverURL' => $val['basicInfo']['coverURL'],
                'creationTime' => $val['basicInfo']['creationTime'],
                'size' => $val['basicInfo']['size'],
            ];
        }
        return $model->makePaginator(
            $totalPages, // 传入总记录数
            $list // 传入数据二维数组
        );

    }
}