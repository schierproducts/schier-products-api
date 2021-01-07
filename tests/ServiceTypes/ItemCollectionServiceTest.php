<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\ProductResources;
use SchierProducts\SchierProductApi\SimpleProduct;

class ItemCollectionServiceTest  extends \PHPUnit\Framework\TestCase
{
    protected ProductApiClient $client;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->client = new ProductApiClient([
            'api_key' => getenv('API_KEY') ? getenv('API_KEY') : 'SAMPLE_KEY',
            'api_base' => "http://product-api.test"
        ]);

//        $factory = new \Illuminate\Http\Client\Factory();
//        $factory->fake([
//            SchierProductApi::$apiBase.'/collections' => \Illuminate\Http\Client\Factory::response(self::allProductsResponse()),
//            SchierProductApi::$apiBase.'/products/8030-003-01' => \Illuminate\Http\Client\Factory::response(self::productCc1Response()),
//        ]);
//        SchierProductApi::setHttpClient($factory);
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
    }
}