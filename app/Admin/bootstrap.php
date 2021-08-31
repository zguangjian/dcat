<?php

use App\Admin\Extensions\ButtonColor;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
define('imgHost', config('filesystems.disks.oss.endpoint'));

Grid::resolving(function (Grid $grid) {

    $grid->model()->orderBy('id', 'desc');
    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
        //$actions->disableDelete();
        //$actions->disableEdit();
    });
});
Grid\Column::extend('color', function ($value, $color) {
    return "<span style='color: $color'>$value</span>";
});
Grid\Column::extend('bg-color', function ($value, $color) {
    return "<span style='background-color: $color'>$value</span>";
});

Grid\Column::extend('statusColor', ButtonColor::class);


