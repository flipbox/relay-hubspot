<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\ContactList\Contacts;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\ResourceV1;
use Flipbox\Relay\Middleware\ClearSimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Remove extends HttpRelayBuilder
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
     * @param string $id
     * @param array $payload
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $id,
        array $payload,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . ':' . $id;

        $this->addUri($id, $logger)
            ->addPayload($payload, $logger)
            ->addCache($cache, $cacheKey, $logger);
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
     * @param string $id
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $id, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV1::class,
            'method' => 'POST',
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/' . $id . '/remove',
            'logger' => $logger ?: $this->getLogger()
        ]);
    }

    /**
     * @param CacheInterface $cache
     * @param string|null $key
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addCache(CacheInterface $cache, string $key = null, LoggerInterface $logger = null)
    {
        return $this->addAfter('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'cache' => $cache,
            'key' => $key
        ], 'body');
    }
}
