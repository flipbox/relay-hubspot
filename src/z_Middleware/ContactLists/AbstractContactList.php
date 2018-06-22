<?php

namespace Flipbox\Relay\HubSpot\z_Middleware\ContactLists;

use Flipbox\Relay\HubSpot\z_Middleware\AbstractMiddleware;
use Flipbox\Relay\HubSpot\z_Middleware\V1Trait;

abstract class AbstractContactList extends AbstractMiddleware
{

    use V1Trait;

    /**
     * The resource name
     */
    const RESOURCE = 'contacts';

    /**
     * @param string $path
     * @return string
     */
    protected function assemblePath(string $path): string
    {
        return $this->assembleVersionPath(static::RESOURCE, $path);
    }
}
