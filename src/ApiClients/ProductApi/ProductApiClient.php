<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi;

use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product;
use SchierProducts\SchierProductApi\Client;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\Resources;
use SchierProducts\SchierProductApi\Service;

/**
 * Client used to send requests
 *
 * @ProductApiClient
 * @package SchierProducts\SchierProductApi
 * @property \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductTypeService $productTypes
 * @property \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService $products
 */
class ProductApiClient extends Client\BaseSchierClient
{
    /**
     * @var null|\SchierProducts\SchierProductApi\Service\ServiceFactory
     */
    private $serviceFactory;

    /**
     * @param string $name
     * @return Service\AbstractService|Service\AbstractServiceFactory|Service\ServiceFactory|null
     */
    public function __get($name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new \SchierProducts\SchierProductApi\Service\ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }

    /**
     * @param string|array|null $key
     * @param array $params
     * @return Collection|ProductType
     * @throws Exception\ApiErrorException
     */
    public function productTypes($key = null, array $params = [])
    {
        // if no key is supplied, then it is inferred that
        // a collection of product types are desired
        if ($key && is_string($key)) {
            return $this->productTypes
                ->retrieve($key, $params);
        }

        return $this->productTypes
            ->all($params);
    }

    /**
     * @param string|array|null $partNumber
     * @param array $params
     * @return Collection|Product|Resources\InventoryItem
     * @throws Exception\ApiErrorException
     */
    public function products($partNumber = null, array $params = [])
    {
        // if no part number is supplied, then it is inferred that
        // a collection of products are desired
        if ($partNumber && is_string($partNumber)) {
            return $this->products
                ->retrieve($partNumber, $params);
        }

        return $this->products
            ->all($params);
    }
}