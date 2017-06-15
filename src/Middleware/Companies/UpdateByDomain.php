<?php

namespace Flipbox\Relay\HubSpot\Middleware\Companies;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UpdateByDomain extends AbstractCompany
{
    /**
     * @var string
     */
    public $domain;

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
        return "companies/domain/{$this->domain}";
    }
}
