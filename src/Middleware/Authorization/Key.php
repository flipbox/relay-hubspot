<?php

/**
 * REST Middleware
 *
 * @package    Force
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/craft/force/license
 * @version    Release: 1.3.0
 * @link       https://github.com/FlipboxFactory/Force
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Relay\HubSpot\Middleware\Authorization;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Key extends AbstractMiddleware implements AuthorizationInterface
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
