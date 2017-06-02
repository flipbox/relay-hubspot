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

namespace Flipbox\Relay\Hubspot\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client extends AbstractMiddleware
{

    /**
     * @inheritdoc
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        // Prepare request
        $request = $this->prepRequest($request);

        // Call API
        $response = $this->call($request, $response);

        // Onward
        $response = $next($request, $response);

        return $response;

    }

    /**
     * Call the API
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function call(RequestInterface $request, ResponseInterface $response)
    {

        try {

            // todo is there a way to append to an existing guzzle response?

            $client = new GuzzleHttpClient();

            $httpResponse = $client->send($request);

        } catch (ClientException $e) {

            $this->error(
                "API Exception",
                [
                    'exception' => $e
                ]
            );

            $httpResponse = $e->getResponse();

        }

        // Sync responses
        return $this->syncResponse($httpResponse, $response);

    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function prepRequest(RequestInterface $request)
    {
        return $request->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }

    /**
     * @param HttpResponse $httpResponse
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function syncResponse(HttpResponse $httpResponse, ResponseInterface $response)
    {
        // Add headers
        foreach ($httpResponse->getHeaders() as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        return $response->withStatus($httpResponse->getStatusCode(), $httpResponse->getReasonPhrase())
            ->withBody($httpResponse->getBody())
            ->withProtocolVersion($httpResponse->getProtocolVersion());
    }
}
