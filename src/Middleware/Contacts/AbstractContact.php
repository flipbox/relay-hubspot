<?php

namespace Flipbox\Relay\Hubspot\Middleware\Contacts;

use Flipbox\Relay\Hubspot\Middleware\AbstractMiddleware;
use Flipbox\Relay\Hubspot\Middleware\V1Trait;

abstract class AbstractContact extends AbstractMiddleware
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
