<?php

namespace SchierProducts\SchierProductApi\ApiClients\GreaseApi\Service;

use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Service\ApiService;

class GreaseRatingService extends ApiService
{
    const PATH = '/grease/grease-ratings';

    /**
     * @param $params
     * @param $opts
     * @return Collection<\SchierProducts\SchierProductApi\ApiClients\GreaseApi\Resources\GreaseRating>
     */
    public function all($params = null, $opts = null) : Collection
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }
}