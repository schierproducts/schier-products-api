<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Schier Product API Key
     |--------------------------------------------------------------------------
     |
     | The unique API key provided to you from the Schier API dashboard (https://api.schierproducts.com)
     |
     */
    'key' => env('SCHIER_PRODUCT_API_KEY', null),

    /*
     |--------------------------------------------------------------------------
     | Schier API Base
     |--------------------------------------------------------------------------
     |
     | If you are trying to connect to another environment other than the default
     | production environment, define the base here. FOR TESTING ONLY!!!
     |
     */
    'base' => env('SCHIER_PRODUCT_API_BASE', 'https://api.schierproducts.com'),

    /*
     |--------------------------------------------------------------------------
     | API Version
     |--------------------------------------------------------------------------
     |
     | Schier will always use the most recent version of the API. However if
     | you are trying to connect to an older version, define it here.
     |
     */
    'version' => env('SCHIER_PRODUCT_API_VERSION', '1'),
];