<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Middleware;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class ResourceV1 extends \Flipbox\Relay\HubSpot\Middleware\Resource
{
    /**
     * The API Version
     */
    const VERSION = 'v1';

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
