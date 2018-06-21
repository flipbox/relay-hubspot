<?php

namespace Flipbox\Relay\HubSpot\Segment\TimelineEvents;

use Flipbox\Relay\HubSpot\Middleware\TimelineEvents\Create as TimelineEventsCreateMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;

class Create extends AbstractSegment
{

    /**
     * @var string
     */
    public $payload;

    /**
     * @var int
     */
    public $appId;

    /**
     * @return array
     */
    protected function defaultSegments(): array
    {
        return [
            'body' => [
                'class' => JsonRequestMiddleware::class,
                'payload' => $this->payload,
                'logger' => $this->getLogger()
            ],
            'uri' => [
                'class' => TimelineEventsCreateMiddleware::class,
                'appId' => $this->appId,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
