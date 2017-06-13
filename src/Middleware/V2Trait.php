<?php

namespace Flipbox\Relay\HubSpot\Middleware;

trait V2Trait
{

    protected $version = 'v2';

    /**
     * @param string $resource
     * @param string $path
     * @return string
     */
    protected function assembleVersionPath(string $resource, string $path): string
    {
        return $resource . '/' . $this->version . '/' . $path;
    }
}
