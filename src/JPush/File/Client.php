<?php

/*
 * This file is part of the hedeqiang/easyjiguang.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang\JPush\File;

use EasyJiGuang\Kernel\Exceptions\InvalidConfigException;
use EasyJiGuang\Kernel\Support\BaseClient;
use EasyJiGuang\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    const ENDPOINT_TEMPLATE = 'https://api.jpush.cn/v3/files';

    const ENDPOINT_VERSION = 'v3';

    /**
     * @param string $type
     * @param        $path
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface|string
     */
    public function files(string $type, $path)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $type);

        return $this->httpUpload($url, ['filename' => $path], $this->getHeader());
    }

    /**
     * 查询有效文件列表.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface|string
     */
    public function getFiles()
    {
        return $this->httpGet(self::ENDPOINT_TEMPLATE, [], $this->getHeader());
    }

    /**
     * 删除文件.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface|string
     */
    public function deleteFiles(string $file_id)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $file_id);

        return $this->httpDelete($url, $this->getHeader());
    }

    /**
     * 查询指定文件详情.
     *
     *@throws GuzzleException
     * @throws InvalidConfigException
     *
     * @return array|Collection|object|ResponseInterface|string
     */
    public function getFilesById(string $file_id)
    {
        $url = $this->buildEndpoint(self::ENDPOINT_TEMPLATE, $file_id);

        return $this->httpGet($url, [], $this->getHeader());
    }
}
