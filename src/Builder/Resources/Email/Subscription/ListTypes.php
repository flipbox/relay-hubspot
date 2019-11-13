<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Email\Subscription;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\ResourceV1;
use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.2.0
 */
class ListTypes extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'email/public';

    /**
     * The resource
     */
    const RESOURCE = 'subscriptions';

    /**
     * Upsert constructor.
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::NODE . '/' . self::RESOURCE;

        $this->addUri($logger)
            ->addCache($cache, $cacheKey, $logger);
    }

    /**
     * @param string|null $id
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'node' => self::NODE,
            'resource' => self::RESOURCE,
            'logger' => $logger ?: $this->getLogger()
        ]);
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
}
