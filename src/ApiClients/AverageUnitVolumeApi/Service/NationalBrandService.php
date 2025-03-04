<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources\NationalBrand;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Service\ApiService;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;

class NationalBrandService extends ApiService
{
    const PATH = '/average-unit-volume/brands';

    public function all(?array $params = null, null|array|RequestOptions $opts = null) : Collection|InventoryItem
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }

    public function retrieve(string $key, array $params = [], null|array|RequestOptions $opts = null) : \SchierProducts\SchierProductApi\Resources\InventoryItem
    {
        return $this->request('get', $this->buildPath(self::PATH.'/%s', $key), $params, $opts);
    }

}