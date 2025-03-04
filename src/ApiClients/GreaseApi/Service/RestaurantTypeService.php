<?php

namespace SchierProducts\SchierProductApi\ApiClients\GreaseApi\Service;

use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Service\ApiService;

class RestaurantTypeService extends ApiService
{
    const PATH = '/grease/restaurant-types';

    /**
     * @param $params
     * @param $opts
     * @return Collection<RestaurantType>
     */
    public function all($params = null, $opts = null) : Collection
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }

    /**
     * @param $key
     * @param $params
     * @param $opts
     * @return RestaurantType
     */
    public function retrieve($key, $params = null, $opts = null): InventoryItem
    {
        return $this->request('get', $this->buildPath(self::PATH.'/%s', $key), $params, $opts);
    }

}