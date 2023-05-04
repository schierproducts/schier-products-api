<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class ProductResource
 *
 * Base-class for attributes that further define a product
 *
 * @package SchierProducts\SchierProductApi\ProductResources
 */
class ProductResource extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'product-resource';

    /**
     * @return string the full API URL for this API resource
     */
    public function instanceUrl()
    {
        return '';
    }
}