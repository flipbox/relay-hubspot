<?php

namespace Flipbox\Relay\HubSpot\Middleware;

use Psr\Http\Message\RequestInterface;

abstract class AbstractMiddleware extends \Flipbox\Relay\Middleware\AbstractMiddleware
{
    /**
     * The URI Host
     */
    const HOST = 'api.hubapi.com';

    /**
     * The URI Scheme
     */
    const SCHEME = 'https';

    /**
     * The API endpoint path, after the version
     *
     * @return string
     */
    abstract protected function getPath(): string;

    /**
     * @param string $path
     * @return string
     */
    abstract protected function assemblePath(string $path): string;

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    protected function prepareUri(RequestInterface $request)
    {
        return $request->withUri(
            $request->getUri()
                ->withHost(static::HOST)
                ->withScheme(static::SCHEME)
                ->withPath(
                    $this->assemblePath($this->getPath())
                )
        );
    }
}
