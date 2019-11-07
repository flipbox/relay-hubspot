<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Company;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonMiddleware;
use Flipbox\Relay\HubSpot\Middleware\ResourceV2;
use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.1.0
 */
class ListByDomain extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'companies';

    /**
     * The resource
     */
    const RESOURCE = 'domains';

    /**
     * @param string $domain
     * @param array $payload
     * @param CacheInterface $cache
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $domain,
        array $payload,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    )
    {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . ':' . $domain . ':companies:' . md5(serialize($payload));

        $this->addUri($domain, $logger)
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
    protected function addUri(string $domain, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV2::class,
            'method' => 'POST',
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/' . $domain . '/companies',
            'logger' => $logger ?: $this->getLogger()
        ]);
    }
}
