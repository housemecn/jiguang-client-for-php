<?php

/*
 * This file is part of the hedeqiang/easyjiguang.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyJiGuang\Kernel\Traits;

use EasyJiGuang\Kernel\Contracts\ArrayAble;
use EasyJiGuang\Kernel\Exceptions\InvalidArgumentException;
use EasyJiGuang\Kernel\Exceptions\InvalidConfigException;
use EasyJiGuang\Kernel\Http\Response;
use EasyJiGuang\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait ResponseCastable.
 */
trait ResponseCastable
{
    /****
     * @param  ResponseInterface  $response
     * @param  string|null        $type
     *
     * @return array|Response|Collection|mixed|object
     * @throws InvalidConfigException
     */
    protected function castResponseToType(ResponseInterface $response, string $type = null)
    {
        $response = Response::buildFromPsrResponse($response);
        $response->getBody()->rewind();

        switch ($type ?? 'array') {
            case 'collection':
                return $response->toCollection();
            case 'array':
                return $response->toArray();
            case 'object':
                return $response->toObject();
            case 'raw':
                return $response;
            default:
                if (!is_subclass_of($type, ArrayAble::class)) {
                    throw new InvalidConfigException(sprintf('Config key "response_type" classname must be an instanceof %s', ArrayAble::class));
                }

                return new $type($response);
        }
    }

    /****
     * @param               $response
     * @param  string|null  $type
     *
     * @return array|Response|Collection|mixed|object
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    protected function detectAndCastResponseToType($response, string $type = null)
    {
        switch (true) {
            case $response instanceof ResponseInterface:
                $response = Response::buildFromPsrResponse($response);

                break;
            case $response instanceof ArrayAble:
                $response = new Response(200, [], json_encode($response->toArray()));

                break;
            case ($response instanceof Collection) || is_array($response) || is_object($response):
                $response = new Response(200, [], json_encode($response));

                break;
            case is_scalar($response):
                $response = new Response(200, [], (string) $response);

                break;
            default:
                throw new InvalidArgumentException(sprintf('Unsupported response type "%s"', gettype($response)));
        }

        return $this->castResponseToType($response, $type);
    }
}
