<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Blog\Posts;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\ResourceV2;
use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.3.0
 */
class All extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'content/api';

    /**
     * The resource
     */
    const RESOURCE = 'blog-posts';

    /**
     * @param array $params
     * @param CacheInterface $cache
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        array $params,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . md5(serialize($params));

        $this->addUri($params, $logger)
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
        return $this->addAfter('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'cache' => $cache,
            'key' => $key
        ], 'body');
    }

    /**
     * @param string $domain
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(array $params, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV2::class,
            'method' => 'GET',
            'params' => $params,
            'node' => self::NODE,
            'resource' => self::RESOURCE,
            'logger' => $logger ?: $this->getLogger()
        ]);
    }
}
