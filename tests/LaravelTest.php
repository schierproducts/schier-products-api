<?php


namespace SchierProducts\SchierProductApi\Tests;


use Orchestra\Testbench\TestCase;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Facades\SchierApi;
use SchierProducts\SchierProductApi\SchierProductApiServiceProvider;
use SchierProducts\SchierProductApi\Utilities\Utilities;

class LaravelTest extends TestCase
{
    use WithMockResponses;

    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app): array
    {
        return [
            SchierProductApiServiceProvider::class,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getPackageAliases($app)
    {
        return [
            'SchierApi' => SchierApi::class,
        ];
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\SchierProductApiServiceProvider::register
     */
    public function facade_class_is_being_hydrated_correctly()
    {
        $apiKey = SchierApi::getApiKey();
        $apiBase = SchierApi::getApiBase();

        $this->assertNotNull($apiKey);
        $this->assertNotNull($apiBase);
        $this->assertEquals(config('product-api.key'), $apiKey);
        $this->assertEquals(config('product-api.base'), $apiBase);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient::productTypes
     */
    public function product_types_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productTypeResponse()), []);

        SchierApi::shouldReceive('productTypes')
            ->once()
            ->andReturn($formattedResponse);

        $response = SchierApi::product()->productTypes();

        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient::productTypes
     */
    public function product_type_by_key_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productTypeSingleResponse()), []);

        SchierApi::shouldReceive('productTypes')
            ->once()
            ->withArgs([ 'sampling_port' ])
            ->andReturn($formattedResponse);

        $response = SchierApi::product()->productTypes('sampling_port');

        $this->assertInstanceOf(ProductType::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient::products
     */
    public function products_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->allProductsResponse()), []);

        SchierApi::shouldReceive('products')
            ->once()
            ->andReturn($formattedResponse);

        $response = SchierApi::product->products();

        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient::products
     */
    public function single_product_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productGb1Response()), []);

        SchierApi::shouldReceive('products')
            ->once()
            ->withArgs([ '4060-001-04' ])
            ->andReturn($formattedResponse);

        $response = SchierApi::product()->products('4060-001-04');

        $this->assertInstanceOf(Product::class, $response);
    }
}