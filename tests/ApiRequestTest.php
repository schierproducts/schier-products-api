<?php


namespace SchierProducts\SchierProductApi\Tests;

use \SchierProducts\SchierProductApi\Client;
use \SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\SchierProductApi;

class ApiRequestTest extends \PHPUnit\Framework\TestCase
{
    use WithFaker;

    const AGS1_RESPONSE = '{"data":{"name":"AGS1","short_name":"AGS1","type":"Support Kit","part_number":"8020-003-01","store_id":"263","description":"Above grade support kit for use with the GB-250 in suspended installations only.","short_description":"Above grade support kit for use with the GB-250 in suspended installations only.","images":{"primary":{"orig":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image.png","lg":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_lg.png","md":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_md.png","sm":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_sm.png"},"dimension":{"orig":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image.png","lg":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_lg.png","md":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_md.png","sm":"https:\/\/d1v15ko52mzsn3.cloudfront.net\/f076f00b-40b6-4f14-9ecb-f41c2144f469\/img\/no-image_sm.png"}},"price":{"list":"593.00","retail":{"multiplier":0.7,"price":"415.10"},"wholesale":{"multiplier":0.55,"price":"326.15"}},"dimensions":{"standard":{"length":{"value":46,"unit":"in"},"width":{"value":4,"unit":"in"},"height":{"value":4,"unit":"in"},"weight":{"value":20,"unit":"lbs"}},"metric":{"length":{"value":116.8,"unit":"cm"},"width":{"value":10.2,"unit":"cm"},"height":{"value":10.2,"unit":"cm"},"weight":{"value":9.1,"unit":"kg"}}},"shipping_dimensions":{"standard":{"length":{"value":46,"unit":"in"},"width":{"value":4,"unit":"in"},"height":{"value":4,"unit":"in"},"weight":{"value":20,"unit":"lbs"}},"metric":{"length":{"value":116.8,"unit":"cm"},"width":{"value":10.2,"unit":"cm"},"height":{"value":10.2,"unit":"cm"},"weight":{"value":9.1,"unit":"kg"}}},"related_products":[],"accessories":[],"options":[],"certifications":[],"spec_sheet":{"pdf":"https:\/\/schier-resources.s3.us-east-2.amazonaws.com\/documents\/ags1\/spec-sheet-pdf.pdf","dwg":"https:\/\/schier-resources.s3.us-east-2.amazonaws.com\/documents\/ags1\/spec-sheet-dwg.zip"},"installation_guide":{"pdf":null,"pdf_french":null,"pdf_spanish":null,"dwg":null},"revit":null,"owners_manual":null,"csi_masterspec":null}}';

    /**
     * @test
     * @covers Client\RequestClient::request
     * @throws \Exception
     */
    public function request_gets_unexpected_value_exception()
    {
        $url = $this->faker->url;
        $instance = Client\RequestClient::instance();
        $method = "what";

        $this->expectException(Exception\UnexpectedValueException::class);
        $this->expectDeprecationMessage("Unrecognized method ".$method);

        $instance->request($method, $url);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiRequest::getDefaultHeaders
     */
    public function request_gets_default_headers()
    {
        $sampleKey = $this->faker->password(20, 40);
        $request = new \SchierProducts\SchierProductApi\ApiRequest($sampleKey);
        $headers = $request->getDefaultHeaders();
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('X-Schier-Client-User-Agent', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertJson($headers['X-Schier-Client-User-Agent']);
        $agent = json_decode($headers['X-Schier-Client-User-Agent']);
        $this->assertEquals('php', $agent->lang);
        $this->assertEquals(\PHP_VERSION, $agent->lang_version);
        $this->assertEquals('schier', $agent->publisher);
        $this->assertEquals($headers['Authorization'], 'Bearer ' . $sampleKey);
        $this->assertEquals($headers['Content-Type'], 'application/json');
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiRequest::_requestRaw
     */
    public function request_gets_authentication_exception()
    {
        $factory = new \Illuminate\Http\Client\Factory();
        $factory->fake();

        $this->expectException(Exception\AuthenticationException::class);

        $request = new \SchierProducts\SchierProductApi\ApiRequest();
        $request->request('get', '/products');
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiRequest::_requestRaw
     */
    public function request_gets_authentication_exception_with_status_and_message()
    {
        $factory = new \Illuminate\Http\Client\Factory();
        $factory->fake();

        $request = new \SchierProducts\SchierProductApi\ApiRequest();
        try {
            $request->request('get', '/products');
        } catch (Exception\AuthenticationException $exception) {
            $message = $exception->getMessage();

            $this->assertEquals(403, $exception->httpStatus);
            $this->assertStringContainsString("SchierProductApi::setApiKey(<API-KEY>)", $message);
        }
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiRequest::request
     */
    public function request_gets_successful_response()
    {
        $productNumber = '8020-003-01';
        $url = SchierProductApi::$apiBase.'/products/*';

        $factory = new \Illuminate\Http\Client\Factory();
        $factory = $factory->fake([
            $url => \Illuminate\Http\Client\Factory::response(self::AGS1_RESPONSE)
        ]);

        $sampleKey = $this->faker->password(20, 40);
        $handler = new \SchierProducts\SchierProductApi\ApiRequest($sampleKey);
        $handler->setHttpClient($factory);
        $response = $handler->request('get', '/products/'.$productNumber);
        /**
         * @var \SchierProducts\SchierProductApi\ApiResponse $response
         */
        $response = $response[0];
        $this->assertEquals(self::AGS1_RESPONSE, $response->body);
        $this->assertEquals(200, $response->code);
        $this->assertEquals([], $response->headers);
    }
}