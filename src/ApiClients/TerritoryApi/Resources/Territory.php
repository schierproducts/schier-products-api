<?php

namespace SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources;

use SchierProducts\SchierProductApi\Collection;

/**
 * Class Territory
 * @package SchierProducts\SchierProductApi
 * @property string $url
 * @property int $id
 * @property string $name
 * @property string $created
 * @property string $code
 * @property string $rep_firm
 * @property int $population
 * @property Manager $manager
 * @property Collection<string>|null $counties
 * @property Collection<string>|null $zip_codes
 */
class Territory extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'territory';


}