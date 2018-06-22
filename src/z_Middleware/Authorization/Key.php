<?php

namespace Flipbox\Relay\HubSpot\z_Middleware\Authorization;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Key extends AbstractMiddleware
{

    /**
     * @var string
     */
    public $key;

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
        // Requested URI
        $uri = $request->getUri();

        // Get Query
        $query = $uri->getQuery();

        // Append to?
        if (!empty($query)) {
            $query .= '&';
        }

        // Add our key
        $query .= http_build_query([
            'hapikey' => $this->key
        ]);

        return $request->withUri(
            $uri->withQuery($query)
        );
    }
}
