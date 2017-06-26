<?php

namespace Flipbox\Relay\HubSpot\Segment\Companies;

use Flipbox\Relay\HubSpot\Middleware\Companies\Create as CompanyCreateMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\Segments\AbstractSegment;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;

class Create extends AbstractSegment
{

    /**
     * @var string
     */
    public $properties;

    /**
     * @return array
     */
    protected function defaultSegments(): array
    {
        return [
            'body' => [
                'class' => JsonRequestMiddleware::class,
                'payload' => $this->properties,
                'logger' => $this->getLogger()
            ],
            'uri' => [
                'class' => CompanyCreateMiddleware::class,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
