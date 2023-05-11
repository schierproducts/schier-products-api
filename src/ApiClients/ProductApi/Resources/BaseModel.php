<?php

namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class BaseModel
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property boolean $is_base_model If the product that was returned was the base model; if available
 * @property string|null $base_part_number If the queried product is NOT the base model, this will return the part number of the base model
 */
class BaseModel extends ProductResource
{
    public const OBJECT_NAME = 'base-model';
}