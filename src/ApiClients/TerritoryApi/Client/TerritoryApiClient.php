<?php

namespace SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Client;

use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\RepFirm;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\Territory;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Service\RepFirmService;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Service\TerritoryService;
use SchierProducts\SchierProductApi\Client\BaseSchierClient;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Service\ServiceFactory;

/**
 * Client used to send requests
 *
 * @TerritoryApiClient
 * @package SchierProducts\SchierProductApi
 * @property TerritoryService $territories
 * @property RepFirmService $repFirms
 */
class TerritoryApiClient extends BaseSchierClient
{

    private ?ServiceFactory $serviceFactory;

    public function __get(string $name)
    {
        if (empty($this->serviceFactory)) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }

    public function territories(string|null $key = null, array|null $params = []): Collection|InventoryItem|Territory
    {
        if ($key) {
            return $this->territories->retrieve($key, $params);
        }

        return $this->territories->all($params);
    }

    public function repFirms(string|null $key = null, array|null $params = []): Collection|InventoryItem|RepFirm
    {
        if ($key) {
            return $this->repFirms->retrieve($key, $params);
        }

        return $this->repFirms->all( $params);
    }


}