<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class FlowRating
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string|null $label If this rating has a specific use case, a label is used
 * @property DimensionSet $flow_rate
 * @property GreaseCapacityMeasurement $grease_capacity
 */
class FlowRating extends ProductResource
{
    public const OBJECT_NAME = 'rating';
}