<?php


namespace SchierProducts\SchierProductApi;


use Illuminate\Support\ServiceProvider;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Client\TerritoryApiClient;

class SchierProductApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = __DIR__ . '/../config/schier-api.php';
        $this->mergeConfigFrom($configPath, 'schier-api');

        $this->app->singleton(ProductApiClient::class, function() {
            return new ProductApiClient([
                'api_key' => config('schier-api.clients.product.key'),
                'api_base' => $this->getBaseRoute(config('schier-api.clients.product.base')),
                'api_version' => config('schier-api.clients.product.version')
            ]);
        });

        $this->app->singleton(TerritoryApiClient::class, function() {
            return new TerritoryApiClient([
                'api_key' => config('schier-api.clients.territory.key'),
                'api_base' => $this->getBaseRoute(config('schier-api.clients.territory.base')),
                'api_version' => config('schier-api.clients.territory.version')
            ]);
        });

        $this->app->bind('schier-api', function() {
            return $this->app->make(SchierApiManager::class);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/schier-api.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('schier-api.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['schier-api', ProductApiClient::class, TerritoryApiClient::class];
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     * @return void
     */
    protected function publishConfig(string $configPath) : void
    {
        $this->publishes([$configPath => config_path('schier-api.php')], 'config');
    }

    /**
     * @param string $route
     * @return string
     */
    private function getBaseRoute(string $route) : string
    {
        return preg_replace("/\/api(?!\.)/", '', $route)."/api";
    }
}