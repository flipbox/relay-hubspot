<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\HubSpot\Builder;

use Flipbox\Relay\Builder\RelayBuilder;
use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Middleware\Authorization as AuthorizationMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client as ClientMiddleware;
use Psr\Log\LoggerInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class HttpRelayBuilder extends RelayBuilder
{
    /**
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null,
        array $config = []
    ) {
        parent::__construct(
            $config
        );

        $this->addAuthorization($authorization, $logger)
            ->addClient($logger);
    }
    /**
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addAuthorization(
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null
    ) {
        return $this->addAfter('token', [
            'class' => AuthorizationMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'authorization' => $authorization
        ], 'cache');
    }

    /**
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addClient(LoggerInterface $logger = null)
    {
        return $this->addAfter('client', [
            'class' => ClientMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
        ], 'token');
    }
}
