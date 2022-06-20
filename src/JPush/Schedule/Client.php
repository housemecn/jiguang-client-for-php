<?php

/*
 * This file is part of the hedeqiang/easyjiguang.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang\JPush\Schedule;

use EasyJiGuang\Kernel\Exceptions\InvalidConfigException;
use EasyJiGuang\Kernel\Support\BaseClient;
use EasyJiGuang\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    const ENDPOINT_TEMPLATE = 'https://api.jpush.cn/v3/schedules';

    const ENDPOINT_VERSION = 'v3';

    /**
     * 创建定时任务
     *
     * @param $options
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function addSchedules($options)
    {
        return $this->httpPostJson(self::ENDPOINT_TEMPLATE, $options, $this->getHeader());
    }

    /**
     * 获取有效的 Schedule 列表.
     *
     * @param array|int[] $query
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function getSchedules(array $query = ['page' => 1])
    {
        return $this->httpGet(self::ENDPOINT_TEMPLATE, $query, $this->getHeader());
    }

    /**
     * 获取指定的定时任务
     *
     * @param $scheduleID
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function getSchedulesById($scheduleID)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $scheduleID);

        return $this->httpGet($url, [], $this->getHeader());
    }

    /**
     * 获取定时任务对应的所有 msg_id.
     *
     * @param $scheduleID
     *
     * @return array|Collection|object|ResponseInterface
     * @throws InvalidConfigException
     *
     * @throws GuzzleException
     */
    public function getMsgId($scheduleID)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $scheduleID.'/msg_ids');

        return $this->httpGet($url, [], $this->getHeader());
    }

    /**
     *  修改指定的 Schedule.
     *
     * @param $scheduleID
     * @param $options
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function updateSchedules($scheduleID, $options)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $scheduleID);

        return $this->httpPut($url, $options, $this->getHeader());
    }

    /**
     * 删除指定的 Schedule 任务
     *
     * @param $scheduleID
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function deleteSchedules($scheduleID)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $scheduleID);

        return $this->httpDelete($url, $this->getHeader());
    }
}
