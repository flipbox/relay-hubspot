<?php

namespace Flipbox\Relay\HubSpot\Middleware\Resources\V2;

class Resource extends \Flipbox\Relay\HubSpot\Middleware\Resource
{
    /**
     * The API Version
     */
    const VERSION = 'v2';

    /**
     * @var string
     */
    public $node;

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return $this->node . "/" . self::VERSION . "/" . parent::getPath();
    }
}
