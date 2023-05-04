<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class InstallationOptionsLocation
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property boolean $indoors
 * @property boolean $indoors_buried
 * @property boolean $outdoors
 * @property boolean $outdoors_buried
 * @property boolean $other If the product can be installed in other locations; ie "under sink"
 */
class InstallationOptionsLocation extends ProductResource
{
    public const OBJECT_NAME = 'installation-options-location';
}