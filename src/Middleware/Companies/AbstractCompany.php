<?php

namespace Flipbox\Relay\HubSpot\Middleware\Companies;

use Flipbox\Relay\HubSpot\Middleware\AbstractMiddleware;
use Flipbox\Relay\HubSpot\Middleware\V2Trait;

abstract class AbstractCompany extends AbstractMiddleware
{

    use V2Trait;

    /**
     * The resource name
     */
    const RESOURCE = 'companies';

    /**
     * @param string $path
     * @return string
     */
    protected function assemblePath(string $path): string
    {
        return $this->assembleVersionPath(static::RESOURCE, $path);
    }
}
