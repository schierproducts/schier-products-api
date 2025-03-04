<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\TableGreaseRating;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\TableProduct;
use SchierProducts\SchierProductApi\ApiResource;
use SchierProducts\SchierProductApi\Collection;

/**
 * Class MealTable
 * @property Collection<string,TableProduct> $products
 * @property Collection<string,TableGreaseRating> $greaseRatings
 * @property float $costPerMeal
 */
class MealTable extends ApiResource
{
    const OBJECT_NAME = 'meal-table';

}