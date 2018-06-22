<?php

namespace Flipbox\Relay\HubSpot\z_Segment\Companies;

use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\Companies\UpdateById as CompanyUpdateByIdMiddleware;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;

class UpdateById extends AbstractSegment
{
    /**
     * @var int
     */
    public $id;

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
                'class' => CompanyUpdateByIdMiddleware::class,
                'id' => $this->id,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
