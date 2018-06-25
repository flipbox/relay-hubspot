<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Contact;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\Resources\V1\Resource;
use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class ReadByEmail extends HttpRelayBuilder
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
     * Upsert constructor.
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param string|null $identifier
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
     * @param string|null $identifier
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $identifier, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => Resource::class,
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/email/' . $identifier . '/profile',
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
