<?php


namespace SchierProducts\SchierProductApi\Service;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class AbstractServiceFactory
{
    /** @var \SchierProducts\SchierProductApi\Client\SchierClientInterface */
    private $client;

    /** @var array<string, AbstractService|ServiceFactory> */
    private $services;

    /**
     * @param \SchierProducts\SchierProductApi\Client\SchierClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function getServiceClass($name);

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory|ApiService
     */
    public function __get($name)
    {
        $serviceClass = $this->getServiceClass($name);
        if (null !== $serviceClass) {
            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        \trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}