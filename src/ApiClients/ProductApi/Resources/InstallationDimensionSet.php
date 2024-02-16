<?php

namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class InstallationDimensionSet
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property InstallationDimensionSet $standard US-Standard dimensions (inches, lbs, etc)
 * @property InstallationDimensionSet $metric Dimensions with the metric conversions
 */
class InstallationDimensionSet extends ProductResource
{
    public const OBJECT_NAME = 'installation-dimensions';
}