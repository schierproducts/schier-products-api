<?php

namespace SchierProducts\SchierProductApi\Facades;

class SchierApi extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'schier-api';
    }
}