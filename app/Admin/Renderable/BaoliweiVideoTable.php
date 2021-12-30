<?php

namespace App\Admin\Renderable;

use App\Admin\Repositories\Baoliwei;
use App\Admin\Repositories\Course;
use App\Communal\BaoliweiManage;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class BaoliweiVideoTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new Baoliwei(), function (Grid $grid) {
            $grid->column('id', 'ID');
            $grid->column('coverURL', '封面')->image("", 50);
            $grid->column('title');
            $grid->column('duration', '时长')->display(function ($value) {
                return getTimeHour($value);
            })->copyable();

            $grid->disableActions();
            $grid->disableColumnSelector();
            $grid->showFilterButton();
            $grid->filter(function (Grid\Filter $filter) {

                $filter->like('title')->width(4);
                $filter->equal('cateId', '分类')->width(4)->select(array_column(BaoliweiManage::category()['data'][0]['nodes'], 'text', 'cataid'));
            });
        });
    }
}
