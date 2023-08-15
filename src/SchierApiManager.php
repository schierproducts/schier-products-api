<?php

namespace SchierProducts\SchierProductApi;

use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Client\TerritoryApiClient;

class SchierApiManager
{
    use ManagesApiSettings;

    protected ProductApiClient $productApi;

    protected TerritoryApiClient $territoryApi;

    public function __construct(ProductApiClient $productApi, TerritoryApiClient $territoryApi)
    {
        $this->productApi = $productApi;
        $this->territoryApi = $territoryApi;
    }
    public function product() : ProductApiClient
    {
        return $this->productApi;
    }

    public function territory() : TerritoryApiClient
    {
        return $this->territoryApi;
    }
}