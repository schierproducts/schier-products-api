<?php


namespace SchierProducts\SchierProductApi\Tests;


use Orchestra\Testbench\TestCase;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Facades\ProductApi;
use SchierProducts\SchierProductApi\Product;
use SchierProducts\SchierProductApi\ProductType;
use SchierProducts\SchierProductApi\SchierProductApiServiceProvider;
use SchierProducts\SchierProductApi\Utilities\Utilities;

class LaravelTest extends TestCase
{
    use WithMockResponses;

    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app)
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
            'ProductApi' => ProductApi::class,
        ];
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ProductApiClient::productTypes
     */
    public function product_types_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productTypeResponse()), []);

        ProductApi::shouldReceive('productTypes')
            ->once()
            ->andReturn($formattedResponse);

        $response = ProductApi::productTypes();

        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ProductApiClient::productTypes
     */
    public function product_type_by_key_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productTypeSingleResponse()), []);

        ProductApi::shouldReceive('productTypes')
            ->once()
            ->withArgs([ 'sampling_port' ])
            ->andReturn($formattedResponse);

        $response = ProductApi::productTypes('sampling_port');

        $this->assertInstanceOf(ProductType::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ProductApiClient::products
     */
    public function products_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->allProductsResponse()), []);

        ProductApi::shouldReceive('products')
            ->once()
            ->andReturn($formattedResponse);

        $response = ProductApi::products();

        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * @test
     * @covers SchierProductApiServiceProvider::register
     * @covers \SchierProducts\SchierProductApi\ProductApiClient::products
     */
    public function single_product_can_be_retrieved_via_facade()
    {
        $formattedResponse = Utilities::convertToInventoryItem((array) json_decode($this->productGb1Response()), []);

        ProductApi::shouldReceive('products')
            ->once()
            ->withArgs([ '4060-001-04' ])
            ->andReturn($formattedResponse);

        $response = ProductApi::products('4060-001-04');

        $this->assertInstanceOf(Product::class, $response);
    }
}