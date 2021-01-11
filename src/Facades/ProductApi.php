<?php


namespace SchierProducts\SchierProductApi\Facades;


class ProductApi extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'schier-product-api';
    }
}