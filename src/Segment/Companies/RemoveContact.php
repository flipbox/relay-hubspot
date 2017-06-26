<?php

namespace Flipbox\Relay\HubSpot\Segment\Companies;

use Flipbox\Relay\HubSpot\Middleware\Companies\RemoveContact as RemoveContactMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\Segments\AbstractSegment;

class RemoveContact extends AbstractSegment
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $contactId;

    /**
     * @return array
     */
    protected function defaultSegments(): array
    {
        return [
            'uri' => [
                'class' => RemoveContactMiddleware::class,
                'id' => $this->id,
                'contactId' => $this->contactId,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}