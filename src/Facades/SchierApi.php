<?php

namespace SchierProducts\SchierProductApi\Facades;

/**
 * Class SchierApi
 * @package SchierProducts\SchierProductApi\Facades
 * @method static \SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Client\AverageUnitVolumeClient averageUnitVolume()
 * @method static \SchierProducts\SchierProductApi\ApiClients\GreaseApi\Client\GreaseApiClient grease()
 * @method static \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient product()
 * @method static \SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Client\TerritoryApiClient territory()
 */
class SchierApi extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'schier-api';
    }
}