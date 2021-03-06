<?php


namespace SchierProducts\SchierProductApi\Service;

use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;

/**
 * Abstract base class for all services.
 */
abstract class ApiService
{
    /**
     * @var \SchierProducts\SchierProductApi\Client\SchierClientInterface
     */
    protected $client;

    /**
     * Initializes a new instance of the {@link ApiService} class.
     *
     * @param \SchierProducts\SchierProductApi\Client\SchierClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \SchierProducts\SchierProductApi\Client\SchierClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function formatParams($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key) {
            if (null === $value) {
                $value = '';
            }
        });

        return $params;
    }

    /**
     * @param $method
     * @param $path
     * @param $params
     * @param $options
     * @return InventoryItem
     * @throws \Exception
     */
    protected function request(string $method, string $path, ?array $params = [], ?array $options = null) : InventoryItem
    {
        return $this->getClient()->request($method, $path, static::formatParams($params), $options);
    }

    /**
     * @param $method
     * @param $path
     * @param $params
     * @param $options
     * @return Collection
     */
    protected function requestCollection($method, $path, $params, $options) : Collection
    {
        return $this->getClient()->requestCollection($method, $path, static::formatParams($params), $options);
    }

    /**
     * @param $basePath
     * @param mixed ...$ids
     * @return string
     */
    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === \trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException($msg);
            }
        }

        return \sprintf($basePath, ...\array_map('\urlencode', $ids));
    }
}