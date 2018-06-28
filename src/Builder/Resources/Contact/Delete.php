<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Contact;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\ResourceV1;
use Flipbox\Relay\Middleware\ClearSimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Delete extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'contacts';

    /**
     * The resource
     */
    const RESOURCE = 'contact';

    /**
     * @param string $identifier
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $identifier,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . ':' . $identifier;

        $this->addUri($identifier, $logger)
            ->addCache($cache, $cacheKey, $logger);
    }

    /**
     * @param string|null $id
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $id, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'method' => 'DELETE',
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/vid/' . $id,
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
