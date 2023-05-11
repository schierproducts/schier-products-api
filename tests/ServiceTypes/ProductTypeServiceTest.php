<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Tests\WithMockResponses;

class ProductTypeServiceTest  extends \PHPUnit\Framework\TestCase
{
    use WithMockResponses;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->useClient();
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductTypeService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_all_available_product_types()
    {
        $response = $this->client->productTypes->all();
        $this->assertEquals('list', $response->object);
        $this->assertEquals('/product-types', $response->url);
        $this->assertNotCount(0, $response->allItems());
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductTypeService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_type_based_on_key()
    {
        $response = $this->client->productTypes->retrieve('sampling_port');

        $this->assertEquals('product-type', $response->object);
        $this->assertEquals('/product-types/sampling_port', $response->url);
        $this->assertEquals('Sampling Port', $response->name);
        $this->assertEquals('sampling_port', $response->key);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductTypeService::products
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function get_products_based_on_product_type()
    {
        $response = $this->client->productTypes->products('sampling_port');

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
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType::products
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function get_products_based_on_product_type_from_retrieved_object()
    {
        $response = $this->client->productTypes->all();
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