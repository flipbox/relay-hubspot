<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Company\Contacts;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\ResourceV2;
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
    const NODE = 'companies';

    /**
     * The resource
     */
    const RESOURCE = 'companies';

    /**
     * Upsert constructor.
     * @param string $companyId
     * @param string $contactId
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $companyId,
        string $contactId,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $cacheKey = self::RESOURCE . ':' . $companyId . ':contacts'

        $this->addUri($companyId, $contactId, $logger)
            ->addCache($cache, $cacheKey, $logger);
    }

    /**
     * @param string $companyId
     * @param string $contactId
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $companyId, string $contactId, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV2::class,
            'method' => 'DELETE',
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/' . $companyId . '/contacts/' . $contactId,
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