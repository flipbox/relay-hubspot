<?php

namespace Flipbox\Relay\HubSpot\z_Middleware\Contacts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetByEmail extends AbstractContact
{
    /**
     * @var string
     */
    public $email;

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
        return "contact/email/{$this->email}/profile";
    }
}
