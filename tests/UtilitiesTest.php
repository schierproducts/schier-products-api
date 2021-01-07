<?php


namespace SchierProducts\SchierProductApi\Tests;


use SchierProducts\SchierProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\ProductType;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\Utilities\Utilities;

class UtilitiesTest extends \PHPUnit\Framework\TestCase
{
    use WithFaker;
    use WithProductTypeResponse;

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Utilities\Utilities::urlEncode
     */
    public function url_is_encoded_correctly()
    {
        $url = "https://api.schierproducts.com?key=multiple values&dictionary[]=value1&dictionary[]=value2";
        $result = \SchierProducts\SchierProductApi\Utilities\Utilities::urlEncode($url);

        $this->assertEquals("https%3A%2F%2Fapi.schierproducts.com%3Fkey%3Dmultiple+values%26dictionary[]%3Dvalue1%26dictionary[]%3Dvalue2", $result);
        $this->assertEquals(urldecode($result), $url);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Utilities\Utilities::utf8
     */
    public function returns_utf8_encoded_string()
    {
        $string = $this->faker->words(20, true);
        $encodedString = Utilities::utf8($string);

        $this->assertEquals($string, $encodedString);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Utilities\Utilities::convertToInventoryItem
     */
    public function converts_value_to_new_inventory_item()
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
}