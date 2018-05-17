<?php

namespace Flipbox\Relay\HubSpot\Middleware\TimelineEvents;

use Flipbox\Relay\HubSpot\Middleware\AbstractMiddleware;
use Flipbox\Relay\HubSpot\Middleware\V1Trait;

abstract class AbstractTimelineEvents extends AbstractMiddleware
{

    use V1Trait;

    /**
     * The resource name
     */
    const RESOURCE = 'integrations';

    /**
     * @param string $path
     * @return string
     */
    protected function assemblePath(string $path): string
    {
        return $this->assembleVersionPath(static::RESOURCE, $path);
    }
}
