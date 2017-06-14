<?php

namespace Flipbox\Relay\HubSpot\Segment\ContactLists;

use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\ContactLists\GetAll as ContactListGetAllMiddleware;
use Flipbox\Relay\Middleware\Stash as CacheMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;
use Psr\Cache\CacheItemPoolInterface;

class GetAll extends AbstractSegment
{
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
                'class' => ContactListGetAllMiddleware::class,
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
