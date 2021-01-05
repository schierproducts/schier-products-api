<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\Tests\WithProductTypeResponse;

class ProductTypeServiceTest  extends \PHPUnit\Framework\TestCase
{
    use WithProductTypeResponse;

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductTypeService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_all_available_product_types()
    {
        $client = new ProductApiClient([
            'api_key' => "Sample_Key",
            'api_base' => "http://product-api.test"
        ]);

        $factory = self::factory();
        SchierProductApi::setHttpClient($factory);

        $response = $client->productTypes->all();
        $this->assertEquals('list', $response->object);
        $this->assertEquals('/product-types', $response->url);
        $this->assertNotCount(0, $response->allItems());
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductTypeService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_type_based_on_key()
    {
        $client = new ProductApiClient([
            'api_key' => "Sample_Key",
            'api_base' => "http://product-api.test"
        ]);

        $factory = self::factory();
        SchierProductApi::setHttpClient($factory);

        $response = $client->productTypes->retrieve('sampling_port');

        $this->assertEquals('product-type', $response->object);
        $this->assertEquals('/product-types/sampling_port', $response->url);
        $this->assertEquals('Sampling Port', $response->name);
        $this->assertEquals('sampling_port', $response->key);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductTypeService::products
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function get_products_based_on_product_type()
    {
        $client = new ProductApiClient([
            'api_key' => "Sample_Key",
            'api_base' => "http://product-api.test"
        ]);

        $factory = self::factory();
        SchierProductApi::setHttpClient($factory);

        $response = $client->productTypes->products('sampling_port');

        $this->assertEquals('list', $response->object);
        $this->assertEquals('/product-types/sampling_port/products', $response->url);
        $this->assertNotCount(0, $response->allItems());

        /**
         * @var InventoryItem $firstItem
         */
        $firstItem = $response->first();
        $this->assertEquals('product', $firstItem->object);
        $this->assertEquals('/products/8064-XXX-01', $firstItem->url);
        $this->assertEquals('SV24', $firstItem->name);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ProductType::products
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function get_products_based_on_product_type_from_retrieved_object()
    {
        $client = new ProductApiClient([
            'api_key' => "Sample_Key",
            'api_base' => "http://product-api.test"
        ]);

        $factory = self::factory();
        SchierProductApi::setHttpClient($factory);

        $response = $client->productTypes->all();
        $this->assertNotCount(0, $response->allItems());

        $samplingPort = null;
        foreach($response->allItems() as $productType) {
            if ($productType->key === 'sampling_port') {
                $samplingPort = $productType;
            }
        }

        $this->assertNotNull($samplingPort);

        if ($samplingPort) {
            $products = $samplingPort->products();
            $this->assertNotCount(0, $products->allItems());
        }
    }
}