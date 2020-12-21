<?php


namespace SchierProducts\SchierProductApi\Tests;


use SchierProducts\SchierProductApi\Utilities\Utilities;

class UtilitiesTest extends \PHPUnit\Framework\TestCase
{
    use WithFaker;

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
}