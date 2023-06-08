<?php

namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class ProductOptionAttribute
 *
 * Attributes that come available with specified part number and any associated markup
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string $connection_type The type of connection that is being represented: inlet, outlet, etc
 * @property string $diameter The size of the connection
 * @property string $thread_type The type of thread that is being represented: plain, FPT, MPT, etc
 * @property string|null $connection_feature The type of connection feature that is being represented: Fixed, None, etc
 * @property boolean $has_pumpout_ports Whether or not the option has pumpout ports
 */
class ProductOptionAttribute extends ProductResource
{
    public const OBJECT_NAME = 'product-option-attribute';
}