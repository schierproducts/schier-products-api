<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\SimpleProduct;
use SchierProducts\SchierProductApi\Tests\WithMockResponses;

class ProductServiceTest  extends \PHPUnit\Framework\TestCase
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
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::all
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_all_available_products()
    {
        $response = $this->client->products->all();

        $this->assertEquals('list', $response->object);
        $this->assertEquals('/products', $response->url);
        $this->assertNotCount(0, $response->allItems());
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductImageLibrary
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Dimensions
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Certification
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DocumentLibrary
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_non_customization_product_by_part_number()
    {
        $response = $this->client->products->retrieve('8030-003-01');

        $this->assertEquals('product', $response->object);
        $this->assertEquals('/products/8030-003-01', $response->url);
        $this->assertEquals('CC1', $response->name);
        $this->assertEquals('CC1', $response->short_name);
        $this->assertEquals('Clamping Collar', $response->type);
        $this->assertEquals('8030-003-01', $response->part_number);
        $this->assertEquals('129', $response->store_id);
        $this->assertEquals('Clamping collar for units with 21" covers, recessed and suspended.', $response->short_description);

        // Images validation
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductImageLibrary::class, $response->images);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary::class, $response->images->primary);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary::class, $response->images->dimension);

        // Processing validation
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\AwarenessProduct::class, $response->processing);

        // Dimensions validation
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $response->base_dimensions);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $response->shipping_dimensions);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Dimensions::class, $response->base_dimensions->standard);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::class, $response->base_dimensions->standard->length);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::class, $response->base_dimensions->standard->width);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::class, $response->base_dimensions->standard->height);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::class, $response->base_dimensions->standard->weight);
        $this->assertTrue(isset($response->base_dimensions->standard->weight->value));
        $this->assertTrue(isset($response->base_dimensions->standard->weight->unit));

        // Document validation
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DocumentLibrary::class, $response->spec_sheet);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DocumentLibrary::class, $response->installation_guide);

        // Price validation
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice::class, $response->price);
        $this->assertEquals('438.00', $response->price->list);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price::class, $response->price->wholesale);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price::class, $response->price->retail);
        $this->assertIsFloat($response->price->wholesale->multiplier);
        $this->assertIsString($response->price->wholesale->price);
        $this->assertIsFloat($response->price->retail->multiplier);
        $this->assertIsString($response->price->retail->price);
    }

    /**
     * @test
     * @testdox Grease Interceptor with  flow rate ratings.
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     * @covers \SchierProducts\SchierProductApi\FlowRating
     * @covers \SchierProducts\SchierProductApi\GreaseCapacityMeasurement
     * @covers \SchierProducts\SchierProductApi\InstallationOptions
     * @covers \SchierProducts\SchierProductApi\InstallationOptionsLocation
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_applicable_flow_rate_ratings()
    {
        $response = $this->client->products->retrieve('4060-001-04');
        $this->assertNotCount(0, $response->ratings);

        if (count($response->ratings) > 0) {
            $rating = $response->ratings[0];
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\FlowRating::class, $rating);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $rating->flow_rate);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\GreaseCapacityMeasurement::class, $rating->grease_capacity);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $rating->grease_capacity->volume);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $rating->grease_capacity->weight);
        }

        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptions::class, $response->installation_options);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptionsLocation::class, $response->installation_options->location);
        $this->assertIsBool($response->installation_options->location->indoors);
        $this->assertIsBool($response->installation_options->location->indoors_buried);
        $this->assertIsBool($response->installation_options->location->outdoors);
        $this->assertIsBool($response->installation_options->location->outdoors_buried);
        $this->assertIsBool($response->installation_options->location->other);
        $this->assertIsString($response->installation_options->location_as_text);
        $this->assertIsBool($response->installation_options->traffic_area);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $response->solids_capacity);
        $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class, $response->liquid_capacity);
    }

    /**
     * @test
     * @testdox Grease Interceptor with related products.
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_related_products()
    {
        $response = $this->client->products->retrieve('4060-001-04');

        if (!$response->related_products) {
            $this->markTestSkipped('This product doesn\'t have any related products.');
        }
        $this->assertNotCount(0, $response->related_products->allItems());

        if ($response->related_products->count() > 0) {
            /**
             * @var SimpleProduct $product
             */
            $product = $response->related_products->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\SimpleProduct::class, $product);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice::class, $product->price);
        }
    }

    /**
     * @test
     * @testdox Grease Interceptor with accessories.
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_accessories()
    {
        $response = $this->client->products->retrieve('4060-001-04');

        if (!$response->accessories) {
            $this->markTestSkipped('This product doesn\'t have any accessories.');
        }

        $this->assertNotCount(0, $response->accessories->allItems());

        if ($response->accessories->count() > 0) {
            /**
             * @var SimpleProduct $product
             */
            $product = $response->accessories->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\SimpleProduct::class, $product);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice::class, $product->price);
        }
    }

    /**
     * @test
     * @testdox Grease Interceptor with no available optional configurations.
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function product_with_no_customizations_returns_404()
    {
        $this->expectException(\SchierProducts\SchierProductApi\Exception\InvalidRequestException::class);
        $this->expectErrorMessage('This product cannot be found.');

        $this->client->products->retrieve('4055-XXX-02');
    }

    /**
     * @test
     * @testdox Grease Interceptor with no available optional configurations.
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function product_with_customizations_returns_result()
    {
        $response = $this->client->products->retrieve('4055-007-02');
        $this->assertNotCount(0, $response->options->allItems());

        if ($response->options->count() > 0) {
            /**
             * @var \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductOption $option
             */
            $option = $response->options->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductOption::class, $option);
            $this->assertIsInt($option->id);
            $this->assertIsString($option->name);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\Resources\InventoryItem::class, $option->price);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price::class, $option->price->wholesale);
        }
    }
}