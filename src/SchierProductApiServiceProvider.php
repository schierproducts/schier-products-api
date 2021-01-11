<?php


namespace SchierProducts\SchierProductApi;


use Illuminate\Support\ServiceProvider;

class SchierProductApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('product-api', function() {
            return new ProductApiClient([
                'api_key' => env('SCHIER_PRODUCT_API_KEY'),
                'api_base' => env('SCHIER_PRODUCT_API_BASE', 'https://api.schierproducts.com'),
                'api_version' => env('SCHIER_PRODUCT_API_VERSION', '1')
            ]);
        });
    }
}