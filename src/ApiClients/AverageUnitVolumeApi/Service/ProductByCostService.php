<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Utilities\ProductByCostParamBuilder;
use SchierProducts\SchierProductApi\Service\ApiService;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;

class ProductByCostService extends ApiService
{
    const PATH = '/average-unit-volume/product-by-cost';

    public function recommendedProduct(?ProductByCostParamBuilder $params, null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Resources\InventoryItem
    {
        return $this->request('get', $this->buildPath(self::PATH), $params->toArray(), $opts);
    }

    public function table(?ProductByCostParamBuilder $params, null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Resources\InventoryItem
    {
        return $this->request('get', $this->buildPath(self::PATH . '/table'), $params->toArray(), $opts);
    }
}