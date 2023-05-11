<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Service;

use SchierProducts\SchierProductApi\Exception;

class ProductTypeService extends \SchierProducts\SchierProductApi\Service\ApiService
{
    const PATH = '/product/product-types';
    /**
     * Returns a list of all of the available, active products. The products are returned sorted by name.
     *
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @return \SchierProducts\SchierProductApi\Collection|\SchierProducts\SchierProductApi\Collection<\SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType>
     * @throws Exception\ApiErrorException if the request fails
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }

    /**
     * Retrieves the product type with the given key.
     *
     * @param string $key
     * @param null|array $params
     * @param null|array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType
     * @throws Exception\ApiErrorException if the request fails
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
        return $this->requestCollection('get', $this->buildPath(self::PATH.'/%s/products', $key), $params, $opts);
    }
}