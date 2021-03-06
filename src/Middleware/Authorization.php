<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Middleware;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\Middleware\AbstractMiddleware;
use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Authorization extends AbstractMiddleware
{
    /**
     * @var AuthorizationInterface
     */
    public $authorization;

    /**
     * @inheritdoc
     * @throws InvalidConfigurationException
     */
    public function init()
    {
        parent::init();

        if (!$this->authorization instanceof AuthorizationInterface) {
            throw new InvalidConfigurationException(sprintf(
                "The class '%s' requires an authorization class that is an instance of '%s', '%s' given.",
                get_class($this),
                AuthorizationInterface::class,
                get_class($this->authorization)
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        parent::__invoke($request, $response, $next);

        $request = $this->authorization->prepareAuthorizationRequest($request);

        // Clone in case we need to refresh and resend
        $runner = clone $next;

        return $this->authorization->handleAuthorizationResponse(
            $next($request, $response),
            $request,
            $runner
        );
    }
}
