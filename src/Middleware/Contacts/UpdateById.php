<?php

namespace Flipbox\Relay\HubSpot\Middleware\Contacts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UpdateById extends AbstractContact
{
    /**
     * @var int
     */
    public $id;

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
            $request->withMethod('POST')
        );

        return $next($request, $response);
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return "contact/email/{$this->id}/profile";
    }
}
