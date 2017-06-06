<?php

namespace Flipbox\Relay\HubSpot\Middleware\Authorization;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Token extends AbstractMiddleware
{

    /**
     * @var string|\League\OAuth2\Client\Token\AccessToken
     */
    public $token;

    /**
     * @inheritdoc
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        return $next($this->prepRequest($request), $response);
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function prepRequest(RequestInterface $request)
    {
        return $request->withHeader(
            "Authorization",
            sprintf("Bearer %s", $this->token)
        );
    }
}
