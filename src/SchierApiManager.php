<?php

namespace SchierProducts\SchierProductApi;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Client\AverageUnitVolumeClient;
use SchierProducts\SchierProductApi\ApiClients\GreaseApi\Client\GreaseApiClient;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Client\TerritoryApiClient;

/**
 * Class SchierApiManager
 * @package SchierProducts\SchierProductApi
 * @property ProductApiClient $productApi
 * @property TerritoryApiClient $territoryApi
 * @property GreaseApiClient $greaseApi
 * @property AverageUnitVolumeClient $averageUnitVolumeApi
 */
class SchierApiManager
{
    use ManagesApiSettings;


    public function __construct(
        protected ProductApiClient        $productApi,
        protected TerritoryApiClient      $territoryApi,
        protected GreaseApiClient         $greaseApi,
        protected AverageUnitVolumeClient $averageUnitVolumeApi
    )
    {
    }

    public function product(): ProductApiClient
    {
        return $this->productApi;
    }

    public function territory(): TerritoryApiClient
    {
        return $this->territoryApi;
    }

    public function grease(): GreaseApiClient
    {
        return $this->greaseApi;
    }

    public function averageUnitVolume(): AverageUnitVolumeClient
    {
        return $this->averageUnitVolumeApi;
    }
}