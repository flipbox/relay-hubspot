<?php

namespace Flipbox\Relay\HubSpot\Segment\ContactLists;

use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\ContactLists\Add as ContactListAddMiddleware;
use Flipbox\Relay\Middleware\Stash as CacheMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;
use Psr\Cache\CacheItemPoolInterface;

class Add extends AbstractSegment
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
                'class' => ContactListAddMiddleware::class,
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
