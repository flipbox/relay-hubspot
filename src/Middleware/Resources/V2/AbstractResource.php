<?php

namespace Flipbox\Relay\HubSpot\Middleware\Resources\V2;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;

/**
 * Class AbstractResource
 * @package Flipbox\Relay\HubSpot\Middleware\Resources\V2
 *
 * The anatomy of an API Resource Uri is constructed with this class.  This is the breakdown:
 *
 * {scheme}://{host}/{node}/{version}/{path}
 */
abstract class AbstractResource extends AbstractMiddleware
{
    /**
     * The API Version
     */
    const VERSION = 'v2';

    /**
     * The API Host
     */
    const HOST = 'api.hubapi.com';

    /**
     * The API Scheme
     */
    const SCHEME = 'https';

    /**
     * @var string
     */
    public $node;

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
    protected function assemblePath(string $path): string
    {
        return $this->node . '/' . self::VERSION . '/' . $path;
    }

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
