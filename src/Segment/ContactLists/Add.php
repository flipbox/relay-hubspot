<?php

namespace Flipbox\Relay\HubSpot\Segment\ContactLists;

use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\ContactLists\Add as ContactListAddMiddleware;
use Flipbox\Relay\Middleware\Stash as CacheMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;
use Psr\Cache\CacheItemPoolInterface;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;

class Add extends AbstractSegment
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var array
     */
    public $contactIds = [];

    /**
     * @var array
     */
    public $emails = [];

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
            'body' => [
                'class' => JsonRequestMiddleware::class,
                'payload' => $this->assemblePayload(),
                'logger' => $this->getLogger()
            ],
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

    /**
     * @return array
     */
    protected function assemblePayload(): array
    {
        return [
            'vids' => array_filter($this->contactIds),
            'emails' => array_filter($this->emails)
        ];
    }
}
