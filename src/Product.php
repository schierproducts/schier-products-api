<?php


namespace SchierProducts\SchierProductApi;


use SchierProducts\SchierProductApi\Operations;
use SchierProducts\SchierProductApi\ProductResources\Certification;
use SchierProducts\SchierProductApi\ProductResources\DimensionSet;
use SchierProducts\SchierProductApi\ProductResources\DocumentLibrary;
use SchierProducts\SchierProductApi\ProductResources\FlowRating;
use SchierProducts\SchierProductApi\ProductResources\ProductImageLibrary;

/**
 * Class Product
 *
 * Complete product details with all associated information
 * @package SchierProducts\SchierProductApi
 * @property string|null $description A long-winded description of the product. Will contain some marketing information.
 * @property string|null $short_description A short concise description of the product.
 * @property ProductImageLibrary $images A list of available images.
 * @property DimensionSet $base_dimensions The dimensions of the product
 * @property DimensionSet $shipping_dimensions The shipping dimensions of th product
 * @property Certification[] $certifications List of associated certifications
 * @property DocumentLibrary $spec_sheet The product spec sheet in various formats
 * @property DocumentLibrary $installation_guide The product installation guide in various formats
 * @property string $created A timestamp of when the resource was created
 * @property string|null $revit Link to the Revit (.ra) file; usually compressed into a ZIP file
 * @property string|null $owners_manual Link to the Owners Manual document
 * @property string|null $csi_masterspec Link to the CSI Masterspec document
 * @property FlowRating[] $ratings Additional flow and grease capacity ratings
 * @property Collection<SimpleProduct> $related_products Related products with like options, sizes, etc
 * @property Collection<SimpleProduct> $accessories Compatible accessories for this product
 * @property Collection<SimpleProduct> $options Available customization options
 */
class Product extends SimpleProduct
{
    const OBJECT_NAME = 'product';

    use Operations\All;
    use Operations\Retrieve;

}