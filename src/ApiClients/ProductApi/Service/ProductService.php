<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Service;

use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\Service\ApiService;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;

/**
 * Class ProductService
 * @package SchierProducts\SchierProductApi\Service
 * @extends ApiService
 */
class ProductService extends ApiService
{
    const PATH = '/product/products';
    /**
     * Returns a list of all of the available, active products. The products are returned sorted by name.
     *
     * @param null|array $params
     * @param null|array|RequestOptions $opts
     *
     * @throws Exception\ApiErrorException if the request fails
     */
    public function all(?array $params = null, null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Collection
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }

    /**
     * Retrieves the product with the given part number
     *
     * @param string $partNumber The product's part number
     * @param null|array $params
     * @param null|array|RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(string $partNumber, ?array $params = null, null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
    {
        return $this->request('get', $this->buildPath(self::PATH. '/%s', urlencode($partNumber)), $params, $opts);
    }

    /**
     * Retrieves all variants (if available) based on the submitted part number
     *
     * @param string $partNumber The product's part number
     * @param null|array|RequestOptions $opts
     * @throws Exception\ApiErrorException if the request fails
     */
    public function variants(string $partNumber, null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Collection
    {
        return $this->requestCollection('get', $this->buildPath(self::PATH. '/%s/variants', urlencode($partNumber)), [], $opts);
    }
}