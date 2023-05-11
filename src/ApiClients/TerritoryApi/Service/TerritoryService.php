<?php

namespace SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Service;

use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\Territory;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;

class TerritoryService extends \SchierProducts\SchierProductApi\Service\ApiService
{
    const PATH = '/territory/territories';

    public function all(array|null $params = null, array|RequestOptions|null $opts = null): Collection
    {
        return $this->requestCollection('get', self::PATH, $params, $opts);
    }

    public function retrieve($partNumber, $params = null, $opts = null): InventoryItem|Territory
    {
        return $this->request('get', $this->buildPath(self::PATH, urlencode($partNumber)), $params, $opts);
    }
}