<?php

namespace Flipbox\Relay\HubSpot\z_Segment\Companies;

use Flipbox\Relay\Middleware\Stash as CacheMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Companies\GetByDomain as CompanyByDomainMiddleware;
use Flipbox\Relay\HubSpot\Middleware\Client;
use Flipbox\Relay\Segments\AbstractSegment;
use Psr\Cache\CacheItemPoolInterface;

class GetByDomain extends AbstractSegment
{

    /**
     * @var string
     */
    public $domain;

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
                'class' => CompanyByDomainMiddleware::class,
                'domain' => $this->domain,
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
