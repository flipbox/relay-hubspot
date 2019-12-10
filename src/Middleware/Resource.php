<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 *
 * The anatomy of an API Resource Uri is constructed with this class.  This is the breakdown:
 * {scheme}://{host}/{node}/{version}/{path}
 */
class Resource extends AbstractMiddleware
{
    /**
     * The request method
     */
    public $method = 'GET';

    /**
     * The API Scheme
     */
    const SCHEME = 'https';

    /**
     * The API Host
     */
    const HOST = 'api.hubapi.com';

    /**
     * The resource path
     */
    public $resource;

    /**
     * Optional Query params
     *
     * @var array
     */
    public $params = [];

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);

        $request = $this->prepareUri(
            $request->withMethod($this->method)
        );

        return $next($request, $response);
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    protected function prepareUri(RequestInterface $request)
    {
        $uri = $request->getUri()
            ->withHost(static::HOST)
            ->withScheme(static::SCHEME);

        if (!empty($this->params)) {
            $uri = $uri->withQuery(
                http_build_query($this->params, null, '&', PHP_QUERY_RFC3986)
            );
        }

        return $request->withUri(
            $uri->withPath(
                $this->getPath()
            )
        );
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return "{$this->resource}";
    }
}
