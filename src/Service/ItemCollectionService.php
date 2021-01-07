<?php


namespace SchierProducts\SchierProductApi\Service;

use \SchierProducts\SchierProductApi\Exception;

/**
 * Class ProductService
 * @package SchierProducts\SchierProductApi\Service
 * @extends SchierProducts\SchierProductApi\Service\ApiService
 */
class ItemCollectionService extends \SchierProducts\SchierProductApi\Service\ApiService
{
    /**
     * Returns a list of all of the available, active products. The products are returned sorted by name.
     *
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     *
     * @throws Exception\ApiErrorException if the request fails
     *
     * @return \SchierProducts\SchierProductApi\Collection
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/collections', $params, $opts);
    }

    /**
     * Retrieves the product with the given part number
     *
     * @param string $key The collection's key or "slug"
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\Product
     */
    public function retrieve($key, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/colletions/%s', $key), $params, $opts);
    }
}