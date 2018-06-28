<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\ContactList;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Resources\ResourceV1;
use Psr\Log\LoggerInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Create extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'contacts';

    /**
     * The resource
     */
    const RESOURCE = 'lists';

    /**
     * Upsert constructor.
     * @param array $payload
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        array $payload,
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $this->addUri($logger)
            ->addPayload($payload, $logger);
    }

    /**
     * @param array $payload
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addPayload(array $payload, LoggerInterface $logger = null)
    {
        return $this->addAfter('body', [
            'class' => JsonMiddleware::class,
            'payload' => $payload,
            'logger' => $logger ?: $this->getLogger()
        ], 'uri');
    }

    /**
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'method' => 'POST',
            'node' => self::NODE,
            'resource' => self::RESOURCE,
            'logger' => $logger ?: $this->getLogger()
        ]);
    }
}
