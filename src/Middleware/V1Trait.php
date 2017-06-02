<?php

namespace Flipbox\Relay\Hubspot\Middleware;

trait V1Trait
{

    protected $version = 'v1';

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
