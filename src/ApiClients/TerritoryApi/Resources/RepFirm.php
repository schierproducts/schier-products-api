<?php

namespace SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources;

use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\ApiResource;

/**
 * Class RepFirm
 * @package SchierProducts\SchierProductApi
 * @property string $url
 * @property int $id
 * @property string $name
 * @property string $created
 * @property Collection<Territory>|null $territories
 */
class RepFirm  extends ApiResource
{
    const OBJECT_NAME = 'rep-firm';


}