<?php

/*
 * This file is part of the hedeqiang/jpush.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang;


use EasyJiGuang\JPush\Application as JPush;
use EasyJiGuang\JVerify\Application as JVerify;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/jiguang.php' => config_path('jiguang.php'),
        ], 'jiguang');
    }

    public function register()
    {
        $apps = [
            'verify' => JVerify::class,
            'push'   => JPush::class,
        ];
        foreach ($apps as $name => $class) {
            $this->app->singleton($class, function () {
                $app = new $class(config('jiguang'));
                return $app;
            });
            $this->app->alias($class, $name);
        }


    }

}