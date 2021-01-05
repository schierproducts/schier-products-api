<?php


namespace SchierProducts\SchierProductApi\Tests;

use \SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\SchierProductApi;

class BaseSchierClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\HttpClient\RequestClient::__construct
     */
    public function class_is_constructed_correctly_with_appropriate_defaults()
    {
        $key = "SAMPLE_KEY";
        $client = new \SchierProducts\SchierProductApi\Client\BaseSchierClient($key);
        $this->assertEquals($client->getApiKey(), $key);
        $this->assertEquals($client->getApiBase(), 'https://api.schierproducts.com');
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\HttpClient\RequestClient::__construct
     */
    public function constructor_throws_expected_validation_error()
    {
        $this->expectException('\SchierProducts\SchierProductApi\Exception\InvalidArgumentException');
        $client = new \SchierProducts\SchierProductApi\Client\BaseSchierClient(4);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\HttpClient\RequestClient::validateConfig
     */
    public function configuration_validation_catches_incorrect_api_key()
    {
        $this->expectException('\SchierProducts\SchierProductApi\Exception\InvalidArgumentException');
        $this->expectErrorMessage('api_key cannot contain whitespace');

        $key = "SAMPLE KEY";
        $client = new \SchierProducts\SchierProductApi\Client\BaseSchierClient($key);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\HttpClient\RequestClient::validateConfig
     */
    public function configuration_validation_catches_extra_keys()
    {
        $this->expectException('\SchierProducts\SchierProductApi\Exception\InvalidArgumentException');
        $this->expectErrorMessage('Found unknown key(s) in configuration array: \'author\'');

        $client = new \SchierProducts\SchierProductApi\Client\BaseSchierClient([
            'author' => 'Doug Niccum'
        ]);
    }

    /**
     * @test
     */
    public function api_key_is_set_correctly()
    {
        $client = new \SchierProducts\SchierProductApi\Client\BaseSchierClient(getenv("API_KEY"));

        $this->assertNotNull($client->getApiKey());
    }
}