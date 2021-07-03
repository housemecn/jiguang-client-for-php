<?php

/*
 * This file is part of the hedeqiang/easyjiguang.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang\JPush\Device;

use EasyJiGuang\Kernel\Exceptions\InvalidConfigException;
use EasyJiGuang\Kernel\Support\BaseClient;
use EasyJiGuang\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    const ENDPOINT_TEMPLATE = 'https://device.jpush.cn/v3';

    const ENDPOINT_VERSION = 'v3';

    protected $config;

    /***
     * 查询设备的别名与标签.
     *
     * @param $registration_id
     *
     * @return array|Collection|object|ResponseInterface
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getDevices($registration_id)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'devices/'.$registration_id);

        return $this->httpGet($url, [], $this->getHeader());
    }

    /**
     * 设置设备的别名与标签.
     *
     * @param $registration_id
     * @param $options
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function updateDevices($registration_id, $options)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'devices/'.$registration_id);

        return $this->httpPostJson($url, $options, $this->getHeader());
    }

    /**
     * 查询别名.
     *
     * @param $alias_value
     * @param string[] $platform
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function getAliases($alias_value, array $platform = ['platform ' => 'all'])
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'aliases/'.$alias_value);

        return $this->httpGet($url, $platform, $this->getHeader());
    }

    /**
     * 删除别名.
     *
     * @param $alias_value
     * @param string[] $platform
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function deleteAliases($alias_value, array $platform = ['platform ' => 'all'])
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'aliases/'.$alias_value);

        return $this->httpDelete($url, $this->getHeader(), $platform);
    }

    /**
     * 解绑设备与别名的绑定关系.
     *
     * @param $alias_value
     * @param $options
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function removeAliases($alias_value, $options)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'aliases/'.$alias_value);

        return $this->httpPostJson($url, $options, $this->getHeader());
    }

    /**
     * 查询标签列表.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function getTags()
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'tags');

        return $this->httpGet($url, [], $this->getHeader());
    }

    /**
     * 判断设备与标签绑定关系.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function isDeviceInTag(string $tag_value, string $registration_id)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'tags/'.$tag_value.'/registration_ids/'.$registration_id);

        return $this->httpGet($url, [], $this->getHeader());
    }

    /**
     * 更新标签.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function updateTag(string $tag_value, array $options)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'tags'.$tag_value);

        return $this->httpPostJson($url, $options, $this->getHeader());
    }

    /**
     *  删除标签.
     *
     * @param string[] $platform
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function deleteTag(string $tag_value, array $platform = ['platform ' => 'all'])
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'tags'.$tag_value);

        return $this->httpDelete($url, $this->getHeader(), $platform);
    }

    /**
     * 获取用户在线状态（VIP 专属接口）.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface
     */
    public function status(array $options)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, 'devices/status/');

        return $this->httpPostJson($url, $options, $this->getHeader());
    }
}
