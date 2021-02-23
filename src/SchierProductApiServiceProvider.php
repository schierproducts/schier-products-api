<?php


namespace SchierProducts\SchierProductApi;


use Illuminate\Support\ServiceProvider;
use SchierProducts\SchierProductApi\Facades\ProductApi;

class SchierProductApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = __DIR__ . '/../config/product-api.php';
        $this->mergeConfigFrom($configPath, 'product-api');

        $this->app->bind('product-api', function() {
            return new ProductApiClient([
                'api_key' => config('product-api.key'),
                'api_base' => config('product-api.base'),
                'api_version' => config('product-api.version')
            ]);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/product-api.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('product-api.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['product-api', ProductApiClient::class];
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('product-api.php')], 'config');
    }
}