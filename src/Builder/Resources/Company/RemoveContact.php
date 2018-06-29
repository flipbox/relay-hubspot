<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-hubspot/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-hubspot
 */

namespace Flipbox\Relay\HubSpot\Builder\Resources\Company;

use Flipbox\Relay\HubSpot\AuthorizationInterface;
use Flipbox\Relay\HubSpot\Builder\HttpRelayBuilder;
use Flipbox\Relay\HubSpot\Middleware\ResourceV2;
use Psr\Log\LoggerInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class RemoveContact extends HttpRelayBuilder
{
    /**
     * The node
     */
    const NODE = 'companies';

    /**
     * The resource
     */
    const RESOURCE = 'companies';

    /**
     * Upsert constructor.
     * @param string $companyId
     * @param string $contactId
     * @param AuthorizationInterface $authorization
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        string $companyId,
        string $contactId,
        AuthorizationInterface $authorization,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($authorization, $logger, $config);

        $this->addUri($companyId, $contactId, $logger);
    }

    /**
     * @param string $companyId
     * @param string $contactId
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $companyId, string $contactId, LoggerInterface $logger = null)
    {
        return $this->addBefore('uri', [
            'class' => ResourceV2::class,
            'method' => 'DELETE',
            'node' => self::NODE,
            'resource' => self::RESOURCE . '/' . $companyId . '/contacts/' . $contactId,
            'logger' => $logger ?: $this->getLogger()
        ]);
    }

}