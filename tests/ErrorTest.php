<?php


namespace SchierProducts\SchierProductApi\Tests;

use \SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\SchierProductApi;

class ErrorTest extends \PHPUnit\Framework\TestCase
{
    use WithFaker;

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
            $this->assertStringContainsString("No API key provided.", $message);
        }
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiRequest::handleErrorResponse
     */
    public function request_gets_404_not_found_exception()
    {
        $productNumber = '8020-003-01';
        $url = SchierProductApi::$apiBase.'/products/*';

        $factory = new \Illuminate\Http\Client\Factory();
        $factory = $factory->fake([
            $url => \Illuminate\Http\Client\Factory::response('{"error":"This product could not be found."}', 404)
        ]);

        $sampleKey = $this->faker->password(20, 40);
        $handler = new \SchierProducts\SchierProductApi\ApiRequest($sampleKey);
        $handler->setHttpClient($factory);

        $this->expectException(\SchierProducts\SchierProductApi\Exception\InvalidRequestException::class);

        $handler->request('get', '/products/'.$productNumber);
    }
}