<?php

namespace SchierProducts\SchierProductApi\ApiClients\GreaseApi\Service;

use SchierProducts\SchierProductApi\ApiClients\GreaseApi\Resources\GreaseRating;

/**
 * @property string $url
 * @property string $id
 * @property string $name
 * @property string $key
 * @property int $without_fryer_grease_rating_id
 * @property GreaseRating $without_fryer_grease_rating
 * @property int $with_fryer_grease_rating_id
 * @property GreaseRating $with_fryer_grease_rating
 */
class RestaurantType extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'restaurant-type';
}