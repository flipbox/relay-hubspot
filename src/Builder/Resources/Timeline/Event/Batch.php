<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Timeline\Event;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\ResourceV1;
use Psr\Log\LoggerInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.4
 */
class Batch extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'integrations';

    /**
     * The resource
     */
    const RESOURCE = 'timeline/event/batch';

    /**
     * Upsert constructor.
     * @param string $appId
     * @param array $payload
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $appId,
        array $payload,
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $this->addUri($appId, $logger)
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
     * @param string $appId
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $appId, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'method' => 'PUT',
            'node' => self::NODE,
            'resource' => $appId . '/' . self::RESOURCE,
            'logger' => $logger ?: $this->getLogger()
        ]);
    }
}
