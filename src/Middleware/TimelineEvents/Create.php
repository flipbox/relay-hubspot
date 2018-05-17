<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 */

namespace Flipbox\Relay\HubSpot\Middleware\TimelineEvents;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Create extends AbstractTimelineEvents
{
    public $appId;

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // Prepare request
        $request = $this->prepareUri(
            $request->withMethod('PUT')
        );

        return $next($request, $response);
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return "{$this->appId}/timeline/event";
    }

}