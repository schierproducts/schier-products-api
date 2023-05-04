<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Service;

use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\Service\ApiService;

/**
 * Class ProductService
 * @package SchierProducts\SchierProductApi\Service
 * @extends ApiService
 */
class ProductService extends ApiService
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
        return $this->requestCollection('get', '/products', $params, $opts);
    }

    /**
     * Retrieves the product with the given part number
     *
     * @param string $partNumber The product's part number
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     */
    public function retrieve($partNumber, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/products/%s', urlencode($partNumber)), $params, $opts);
    }
}