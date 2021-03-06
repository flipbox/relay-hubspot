<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Middleware;

use Flipbox\Http\Stream\Factory as StreamFactory;
use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class JsonRequest extends AbstractMiddleware
{
    /**
     * @var array
     */
    public $payload;

    /**
     * @inheritdoc
     * @throws \Flipbox\Http\Stream\Exceptions\InvalidStreamException
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);

        if ($this->payload !== null) {
            $request = $request->withBody(
                StreamFactory::create(
                    json_encode($this->payload)
                )
            );
        }

        return $next($request, $response);
    }
}
