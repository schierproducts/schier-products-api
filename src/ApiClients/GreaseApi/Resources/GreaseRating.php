<?php

namespace SchierProducts\SchierProductApi\ApiClients\GreaseApi\Resources;

/**
 * Class GreaseRatingResource
 * @package SchierProducts\SchierProductApi
 * @property string $url
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property GreasePerServing $grease_per_serving
 */
class GreaseRating extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'grease-rating';
}