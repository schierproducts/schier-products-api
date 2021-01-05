<?php


namespace SchierProducts\SchierProductApi\Service;

use \SchierProducts\SchierProductApi\Exception;

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
}