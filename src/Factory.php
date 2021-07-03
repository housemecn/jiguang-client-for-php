<?php

/*
 * This file is part of the hedeqiang/easyjiguang.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang;

use EasyJiGuang\Kernel\ServiceContainer;

/**
 * @method static \EasyJiGuang\JPush\Application JPush(array $config)
 * @method static \EasyJiGuang\JVerify\Application JVerify(array $config)
 * @method static \EasyJiGuang\JMessage\Application JMessage(array $config)
 * @method static \EasyJiGuang\JMLink\Application JMLink(array $config)
 *                                                                          Class Factory
 */
class Factory
{
    /**
     * @param       $name
     * @param array $config
     *
     * @return ServiceContainer
     */
    public static function make($name, array $config): Kernel\ServiceContainer
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\EasyJiGuang\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @return ServiceContainer
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
