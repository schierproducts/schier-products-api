<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;


use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Operations;

/**
 * Class Product
 *
 * Complete product details with all associated information
 * @package SchierProducts\SchierProductApi
 * @property string|null $description A long-winded description of the product. Will contain some marketing information.
 * @property string|null $short_description A short concise description of the product.
 * @property string|null $shipping_group The shipping table that this product is associated with in ShipperHQ
 * @property ProductImageLibrary $images A list of available images.
 * @property DimensionSet $base_dimensions The dimensions of the product
 * @property DimensionSet $shipping_dimensions The shipping dimensions of th product
 * @property int $manway_access_ports The number of "manway" access ports that require a cover
 * @property Certification[] $certifications List of associated certifications
 * @property DocumentLibrary $spec_sheet The product spec sheet in various formats
 * @property DocumentLibrary $installation_guide The product installation guide in various formats
 * @property string $created A timestamp of when the resource was created
 * @property string|null $revit Link to the Revit (.ra) file; usually compressed into a ZIP file
 * @property string|null $owners_manual Link to the Owners Manual document
 * @property string|null $csi_masterspec Link to the CSI Masterspec document
 * @property InstallationOptions $installation_options Where/how this product can be installed correctly
 * @property FlowRating[] $ratings Additional flow and grease capacity ratings
 * @property DimensionSet|null $solids_capacity If available, solids capacity
 * @property DimensionSet|null $liquid_capacity If available, liquid capacity of the interceptor
 * @property Collection<SimpleProduct>|null $related_products Related products with like options, sizes, etc
 * @property Collection<SimpleProduct>|null $accessories Compatible accessories for this product
 * @property Collection<SimpleProduct>|null $compatible_products Products that reference this product as a compatible accessory
 * @property Collection<ProductOption>|null $options Available customization options
 */
class Product extends SimpleProduct
{
    const OBJECT_NAME = 'product';

    use Operations\All;
    use Operations\Retrieve;

}