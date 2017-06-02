<?php

namespace Flipbox\Relay\Hubspot\Segment\Contacts;

use Flipbox\Cache\Middleware\Cache as CacheMiddleware;
use Flipbox\Relay\Hubspot\Middleware\Contacts\GetById as ContactByIdMiddleware;
use Flipbox\Relay\Hubspot\Middleware\Client;
use Flipbox\Relay\Segments\AbstractSegment;
use Psr\Cache\CacheItemPoolInterface;

class GetById extends AbstractSegment
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var CacheItemPoolInterface
     */
    public $cache;

    /**
     * @return array
     */
    protected function defaultSegments(): array
    {
        return [
            'uri' => [
                'class' => ContactByIdMiddleware::class,
                'id' => $this->id,
                'logger' => $this->getLogger()
            ],
            'cache' => [
                'class' => CacheMiddleware::class,
                'pool' => $this->cache,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
