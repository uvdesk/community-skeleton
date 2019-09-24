<?php

declare(strict_types=1);

namespace ProxyManager\Factory\RemoteObject\Adapter;

use ProxyManager\Factory\RemoteObject\AdapterInterface;
use Zend\Server\Client;

/**
 * Remote Object base adapter
 *
 * @author Vincent Blanchon <blanchon.vincent@gmail.com>
 * @license MIT
 */
abstract class BaseAdapter implements AdapterInterface
{
    /**
     * Adapter client
     *
     * @var \Zend\Server\Client
     */
    protected $client;

    /**
     * Service name mapping
     *
     * @var string[]
     */
    protected $map = [];

    /**
     * Constructor
     *
     * @param Client $client
     * @param array  $map    map of service names to their aliases
     */
    public function __construct(Client $client, array $map = [])
    {
        $this->client = $client;
        $this->map    = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function call(string $wrappedClass, string $method, array $params = [])
    {
        $serviceName = $this->getServiceName($wrappedClass, $method);

        if (\array_key_exists($serviceName, $this->map)) {
            $serviceName = $this->map[$serviceName];
        }

        return $this->client->call($serviceName, $params);
    }

    /**
     * Get the service name will be used by the adapter
     */
    abstract protected function getServiceName(string $wrappedClass, string $method) : string;
}
