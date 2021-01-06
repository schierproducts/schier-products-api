<?php


namespace SchierProducts\SchierProductApi\Tests;


trait WithFaker
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * This method is called before each test.
     *
     * @doesNotPerformAssertions
     */
    protected function setUp() : void
    {
        $this->faker = \Faker\Factory::create();
    }
}