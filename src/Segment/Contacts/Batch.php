<?php

namespace Flipbox\Relay\HubSpot\Segment\Contacts;

use Flipbox\Relay\HubSpot\Middleware\Contacts\Batch as ContactBatchMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;

class Batch extends AbstractSegment
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
                'class' => ContactBatchMiddleware::class,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
