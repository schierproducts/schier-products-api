<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class ProductPrice
 *
 * Pricing information for both wholesale and retail
 *
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string|null $list The product's list price
 * @property Price $retail
 * @property Price $wholesale
 */
class ProductPrice extends ProductResource
{
    public const OBJECT_NAME = 'product-price';

}