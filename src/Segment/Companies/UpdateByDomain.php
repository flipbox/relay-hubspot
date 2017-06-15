<?php

namespace Flipbox\Relay\HubSpot\Segment\Companies;

use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\HubSpot\Middleware\Companies\UpdateByDomain as CompanyUpdateByDomainMiddleware;
use Flipbox\Relay\HubSpot\Middleware\JsonRequest as JsonRequestMiddleware;
use Flipbox\Relay\Segments\AbstractSegment;

class UpdateByDomain extends AbstractSegment
{
    /**
     * @var string
     */
    public $domain;

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
                'class' => CompanyUpdateByDomainMiddleware::class,
                'domain' => $this->domain,
                'logger' => $this->getLogger()
            ],
            'client' => [
                'class' => Client::class,
                'logger' => $this->getLogger()
            ]
        ];
    }
}
