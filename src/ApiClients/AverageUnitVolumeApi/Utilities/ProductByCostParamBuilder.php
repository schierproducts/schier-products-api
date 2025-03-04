<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Utilities;

class ProductByCostParamBuilder
{
    public function __construct(public float $costPerMeal, public ?int $averageAnnualRevenue = null, public ?float $greasePerMeal = null)
    {
    }

    public function toArray(): array
    {
        return [
            'cost_per_meal' => $this->costPerMeal,
            'average_annual_revenue' => $this->averageAnnualRevenue,
            'grease_per_meal' => $this->greasePerMeal
        ];
    }
}