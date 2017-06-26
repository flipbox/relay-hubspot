<?php

namespace Flipbox\Relay\HubSpot\Segment\Contacts;

use Flipbox\Relay\HubSpot\Middleware\Contacts\Create as ContactCreateMiddleware;
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
                'class' => ContactCreateMiddleware::class,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
