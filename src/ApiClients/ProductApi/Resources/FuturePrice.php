<?php

namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductResource;


/**
 * Class FuturePrice
 *
 * If a price change is imminent, the price of the product after the change is approved
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string|null $activeAt The timestamp of when the price will become effective
 */
class FuturePrice extends ProductPrice
{
    const OBJECT_NAME = 'future-price';
}