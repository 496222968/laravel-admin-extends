<?php

namespace Encore\Admin\Scaffold;

use Encore\Admin\Admin;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Extension;

class Scaffold extends Extension
{

    /**
     * Bootstrap this package.
     *
     * @return void
     */
    public static function boot()
    {
        static::registerRoutes();

        Admin::extend('scaffold', __CLASS__);
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    public static function registerRoutes()
    {
        parent::routes(function ($router) {
            $router->get('scaffold', 'Encore\Admin\Scaffold\Controllers\ScaffoldController@index');
            $router->post('scaffold', 'Encore\Admin\Scaffold\Controllers\ScaffoldController@store');
        });
    }

    public static function import()
    {
        $lastOrder = Menu::max('order');

        $root = [
            'parent_id' => 0,
            'order'     => $lastOrder++,
            'title'     => 'Scaffold',
            'icon'      => 'fa-gears',
            'uri'       => 'scaffold',
        ];

        $root = Menu::create($root);

        parent::createPermission('Scaffold', 'ext.scaffold', 'scaffold/*');
    }
}