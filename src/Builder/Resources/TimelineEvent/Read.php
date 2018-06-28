<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\TimelineEvent;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Resources\ResourceV1;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;

class Read extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'integrations';

    /**
     * The resource
     */
    const RESOURCE = 'timeline/event';

    /**
     * @param string $appId
     * @param string $eventTypeId
     * @param string $id
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $appId,
        string $eventTypeId,
        string $id,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . ':' . $appId . ':' . $eventTypeId . ':' . $id;

        $this->addUri($appId, $eventTypeId, $id, $logger)
            ->addCache($cache, $cacheKey, $logger);
    }

    /**
     * @param CacheInterface $cache
     * @param string $key
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addCache(CacheInterface $cache, string $key, LoggerInterface $logger = null)
    {
        return $this->addBefore('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'cache' => $cache,
            'key' => $key
        ], 'token');
    }

    /**
     * @param string $appId
     * @param string $eventTypeId
     * @param string $id
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $appId, string $eventTypeId, string $id, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'node' => self::NODE,
            'resource' => $appId . '/' . self::RESOURCE . '/' . $eventTypeId . '/' . $id,
            'logger' => $logger ?: $this->getLogger()
        ]);
    }
}
