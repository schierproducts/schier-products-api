<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class Certification
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property string $name The name of the certification
 * @property string|null $link A URL to a webpage or a file to view details on this certification
 * @property string|null $type The type of the link; an enumeration of values
 */
class Certification extends ProductResource
{
    const OBJECT_NAME = 'certification';

}