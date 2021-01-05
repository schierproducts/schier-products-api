<?php


namespace SchierProducts\SchierProductApi\Service;

use \SchierProducts\SchierProductApi\Exception;

class ProductTypeService extends \SchierProducts\SchierProductApi\Service\ApiService
{
    /**
     * Returns a list of all of the available, active products. The products are returned sorted by name.
     *
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     * @return \SchierProducts\SchierProductApi\Collection|\SchierProducts\SchierProductApi\Collection<\SchierProducts\SchierProductApi\ProductType>
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/product-types', $params, $opts);
    }

    /**
     * Retrieves the product type with the given key.
     *
     * @param string $key
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\ProductType
     */
    public function retrieve($key, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/product-types/%s', $key), $params, $opts);
    }

    /**
     * Retrieves the products that have been assigned to the queried product type
     *
     * @param string $key
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     * @return \SchierProducts\SchierProductApi\Collection
     */
    public function products($key, $params = null, $opts = null)
    {
        return $this->requestCollection('get', $this->buildPath('/product-types/%s/products', $key), $params, $opts);
    }
}