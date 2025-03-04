<?php

namespace SchierProducts\SchierProductApi\ApiClients\GreaseApi\Client;

use SchierProducts\SchierProductApi\Client\BaseSchierClient;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Service\ServiceFactory;

class GreaseApiClient extends BaseSchierClient
{
    private ?ServiceFactory $serviceFactory;

    public function __get(string $name)
    {
        if (empty($this->serviceFactory)) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }

    public function greaseRatings(array|null $params = []): Collection
    {
        return $this->greaseRatings->all($params);
    }

    public function restaurantTypes(string|null $key = null, array|null $params = []): Collection
    {
        if ($key) {
            return $this->restaurantTypes->retrieve($key, $params);
        }

        return $this->restaurantTypes->all( $params);
    }
}