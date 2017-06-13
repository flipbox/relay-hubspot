<?php

namespace Flipbox\Relay\HubSpot\Segment\Companies;

use Flipbox\Relay\HubSpot\Middleware\Companies\Create as CompanyCreateMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\Segments\AbstractSegment;

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
            'uri' => [
                'class' => CompanyCreateMiddleware::class,
                'properties' => $this->properties,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
