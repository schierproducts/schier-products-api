<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class AwarenessProduct
 *
 * Any processing awareness information regarding lead times and any thresholds that might affect the lead times.
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string $url The processing url that can be used to retrieve the value
 * @property string $name The people-friendly name of the product
 * @property int $lead_time The number of business days required to assemble the product
 * @property int $threshold The number of products required in a single purchase to affect the indicated lead time
 */
class AwarenessProduct extends ProductResource
{
    public const OBJECT_NAME = 'awareness-product';
}