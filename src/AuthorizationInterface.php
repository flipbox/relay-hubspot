<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
interface AuthorizationInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareAuthorizationRequest(
        RequestInterface $request
    ): RequestInterface;

    /**
     * Allow interpretation and subsequent authorization re-tries.
     *
     * @param ResponseInterface $response
     * @param RequestInterface $request
     * @param callable $callable
     * @return ResponseInterface
     */
    public function handleAuthorizationResponse(
        ResponseInterface $response,
        RequestInterface $request,
        callable $callable
    ): ResponseInterface;
}
