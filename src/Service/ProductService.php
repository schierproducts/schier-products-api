<?php


namespace SchierProducts\SchierProductApi\Service;

use \SchierProducts\SchierProductApi\Exception;

/**
 * Class ProductService
 * @package SchierProducts\SchierProductApi\Service
 * @extends SchierProducts\SchierProductApi\Service\ApiService
 */
class ProductService extends \SchierProducts\SchierProductApi\Service\ApiService
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
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\Product
     */
    public function retrieve($partNumber, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/products/%s', urlencode($partNumber)), $params, $opts);
    }
}