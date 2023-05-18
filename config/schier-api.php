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
    'key' => env('SCHIER_API_KEY', null),

    /*
     |--------------------------------------------------------------------------
     | Schier API Base
     |--------------------------------------------------------------------------
     |
     | If you are trying to connect to another environment other than the default
     | production environment, define the base here. FOR TESTING ONLY!!!
     |
     */
    'base' => env('SCHIER_API_BASE', 'https://api.schierproducts.com'),

    /*
     |--------------------------------------------------------------------------
     | API Version
     |--------------------------------------------------------------------------
     |
     | Schier will always use the most recent version of the API. However if
     | you are trying to connect to an older version, define it here.
     |
     */
    'version' => env('SCHIER_API_VERSION', '1'),

    /*
     |--------------------------------------------------------------------------
     | Clients
     |--------------------------------------------------------------------------
     |
     | Define specific keys for specific clients. This is useful if you have separate tokens.
     |
     */
    'clients' => [
        'product' => [
            'key' => env('SCHIER_PRODUCT_API_KEY', env('SCHIER_API_KEY', null)),
            'base' => env('SCHIER_PRODUCT_API_BASE', env('SCHIER_API_BASE', 'https://api.schierproducts.com')),
            'version' => env('SCHIER_PRODUCT_API_VERSION', env('SCHIER_API_VERSION', '1')),
        ],
        'territory' => [
            'key' => env('SCHIER_TERRITORY_API_KEY', env('SCHIER_API_KEY', null)),
            'base' => env('SCHIER_TERRITORY_API_BASE', env('SCHIER_API_BASE', 'https://api.schierproducts.com')),
            'version' => env('SCHIER_TERRITORY_API_VERSION', env('SCHIER_API_VERSION', '1')),
        ],
    ],
];
