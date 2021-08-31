<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    //系统设置
    $router->get('webConfig', 'HomeController@webConfig');
    //会员管理

    $router->resource('member_grade', 'MemberGradeController');

    $router->group(['prefix' => 'member'], function (Router $router) {
        //充值
        $router->resource('wx', 'MemberBindWxController');
        $router->get('config', 'MemberController@config');
        $router->resource('blank', 'MemberBankController');
        $router->resource('order', 'MemberOrderController');
        $router->resource('withdraw', 'MemberWithdrawController');
    });

    //公告管理
    $router->resource('notice', 'NoticeController');
    //商家管理
    $router->group(['prefix' => 'business'], function (Router $router) {
        //充值
        $router->resource('deposit', 'BusinessDepositController');
        $router->get('config', 'BusinessController@config');

    });
    //任务
    $router->group(['prefix' => 'task'], function (Router $router) {

        //增值服务
        $router->resource('increment', 'TaskIncrementController');
        //审核模式
        $router->resource('examine', 'TaskExamineController');
    });
    $router->resource('member', 'MemberController');
    $router->resource('task', 'TaskController');
    $router->resource('business', 'BusinessController');
    $router->resource('task_type', 'TaskTypeController');
    $router->resource('blank', 'BlankController');
    $router->resource('limit_area', 'LimitAreaController');
    $router->resource('district', 'DistrictController');


});

