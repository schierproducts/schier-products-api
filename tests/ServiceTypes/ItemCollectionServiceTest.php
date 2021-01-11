<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ItemCollection;
use SchierProducts\SchierProductApi\Product;
use SchierProducts\SchierProductApi\ProductResources;
use SchierProducts\SchierProductApi\Tests\WithMockResponses;

class ItemCollectionServiceTest  extends \PHPUnit\Framework\TestCase
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
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_all_available_collections()
    {
        $response = $this->client->collections->all();

        $this->assertEquals('list', $response->object);
        $this->assertEquals('/collections', $response->url);
        $this->assertInstanceOf(ItemCollection::class, $response->first());
        $this->assertEquals(2, $response->first()->size);
        $this->assertCount(2, $response->first()->items->allItems());
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_collections_with_parameters_and_filters()
    {
        $response = $this->client->collections->all([
            'only' => [ 'gb-250' ],
            'limit' => 1
        ]);

        $this->assertEquals('list', $response->object);
        $this->assertEquals('/collections?limit=1&only[]=gb-250', $response->url);
        $this->assertCount(1, $response->allItems());
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_single_collection_by_key()
    {
        $response = $this->client->collections->retrieve('gb-1');

        $this->assertEquals('collection', $response->object);
        $this->assertEquals('/collections/gb-1', $response->url);
        $this->assertEquals('GB-1', $response->name);
        $this->assertEquals('gb-1', $response->key);
        $this->assertEquals(2, $response->size);
        $this->assertInstanceOf(ProductResources\ImageLibrary::class, $response->image);
        $this->assertCount(2, $response->items->allItems());
        $this->assertInstanceOf(Product::class, $response->items->first());
    }


}