<?php

namespace Flipbox\Relay\HubSpot\Middleware\Companies;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetById extends AbstractCompany
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
            $request->withMethod('GET')
        );

        return $next($request, $response);
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return "companies/{$this->id}";
    }
}
