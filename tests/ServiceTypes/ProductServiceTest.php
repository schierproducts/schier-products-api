<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\ProductResources\ProductOption;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\ProductResources;
use SchierProducts\SchierProductApi\SimpleProduct;

class ProductServiceTest  extends \PHPUnit\Framework\TestCase
{
    protected ProductApiClient $client;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->client = new ProductApiClient([
            'api_key' => getenv('API_KEY'),
            'api_base' => "http://product-api.test"
        ]);

        $factory = new \Illuminate\Http\Client\Factory();
        $factory->fake([
            SchierProductApi::$apiBase.'/products/8030-003-01' => \Illuminate\Http\Client\Factory::response(self::productCc1Response()),
            SchierProductApi::$apiBase.'/products/4060-001-04' => \Illuminate\Http\Client\Factory::response(self::productGb1Response()),
            SchierProductApi::$apiBase.'/products/4055-XXX-02' => \Illuminate\Http\Client\Factory::response('{"message":"This product cannot be found."}', 404),
            SchierProductApi::$apiBase.'/products/4055-007-02' => \Illuminate\Http\Client\Factory::response(self::productGb250Response()),
        ]);
        SchierProductApi::setHttpClient($factory);
    }

    /**
     * @test
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::all
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
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\Product
     * @covers \SchierProducts\SchierProductApi\ProductResources\ProductImageLibrary
     * @covers \SchierProducts\SchierProductApi\ProductResources\ProductImage
     * @covers \SchierProducts\SchierProductApi\ProductResources\DimensionSet
     * @covers \SchierProducts\SchierProductApi\ProductResources\Dimensions
     * @covers \SchierProducts\SchierProductApi\ProductResources\Measurement
     * @covers \SchierProducts\SchierProductApi\ProductResources\Certification
     * @covers \SchierProducts\SchierProductApi\ProductResources\DocumentLibrary
     * @covers \SchierProducts\SchierProductApi\ProductResources\Price
     * @covers \SchierProducts\SchierProductApi\ProductResources\ProductPrice
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
        $this->assertInstanceOf(ProductResources\ProductImageLibrary::class, $response->images);
        $this->assertInstanceOf(ProductResources\ProductImage::class, $response->images->primary);
        $this->assertInstanceOf(ProductResources\ProductImage::class, $response->images->dimension);

        // Dimensions validation
        $this->assertInstanceOf(ProductResources\DimensionSet::class, $response->base_dimensions);
        $this->assertInstanceOf(ProductResources\DimensionSet::class, $response->shipping_dimensions);
        $this->assertInstanceOf(ProductResources\Dimensions::class, $response->base_dimensions->standard);
        $this->assertInstanceOf(ProductResources\Measurement::class, $response->base_dimensions->standard->length);
        $this->assertInstanceOf(ProductResources\Measurement::class, $response->base_dimensions->standard->width);
        $this->assertInstanceOf(ProductResources\Measurement::class, $response->base_dimensions->standard->height);
        $this->assertInstanceOf(ProductResources\Measurement::class, $response->base_dimensions->standard->weight);
        $this->assertTrue(isset($response->base_dimensions->standard->weight->value));
        $this->assertTrue(isset($response->base_dimensions->standard->weight->unit));

        // Certifications validation
        $this->assertInstanceOf(ProductResources\Certification::class, $response->certifications[0]);
        $this->assertTrue(isset($response->certifications[0]->name));

        // Document validation
        $this->assertInstanceOf(ProductResources\DocumentLibrary::class, $response->spec_sheet);
        $this->assertInstanceOf(ProductResources\DocumentLibrary::class, $response->installation_guide);
        $this->assertStringContainsString('csi-masterspec', $response->csi_masterspec);

        // Price validation
        $this->assertInstanceOf(ProductResources\ProductPrice::class, $response->price);
        $this->assertEquals('393.00', $response->price->list);
        $this->assertInstanceOf(ProductResources\Price::class, $response->price->wholesale);
        $this->assertInstanceOf(ProductResources\Price::class, $response->price->retail);
        $this->assertIsFloat($response->price->wholesale->multiplier);
        $this->assertIsString($response->price->wholesale->price);
        $this->assertIsFloat($response->price->retail->multiplier);
        $this->assertIsString($response->price->retail->price);
    }

    /**
     * @test
     * @testdox Grease Interceptor with  flow rate ratings.
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\Product
     * @covers \SchierProducts\SchierProductApi\FlowRating
     * @covers \SchierProducts\SchierProductApi\GreaseCapacityMeasurement
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_applicable_flow_rate_ratings()
    {
        $response = $this->client->products->retrieve('4060-001-04');
        $this->assertNotCount(0, $response->ratings);

        if (count($response->ratings) > 0) {
            $rating = $response->ratings[0];
            $this->assertInstanceOf(ProductResources\FlowRating::class, $rating);
            $this->assertInstanceOf(ProductResources\DimensionSet::class, $rating->flow_rate);
            $this->assertInstanceOf(ProductResources\GreaseCapacityMeasurement::class, $rating->grease_capacity);
            $this->assertInstanceOf(ProductResources\DimensionSet::class, $rating->grease_capacity->volume);
            $this->assertInstanceOf(ProductResources\DimensionSet::class, $rating->grease_capacity->weight);
        }
    }

    /**
     * @test
     * @testdox Grease Interceptor with related products.
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_related_products()
    {
        $response = $this->client->products->retrieve('4060-001-04');
        $this->assertNotCount(0, $response->related_products->allItems());

        if ($response->related_products->count() > 0) {
            /**
             * @var SimpleProduct $product
             */
            $product = $response->related_products->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\SimpleProduct::class, $product);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ProductResources\ProductPrice::class, $product->price);
        }
    }

    /**
     * @test
     * @testdox Grease Interceptor with accessories.
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function gets_product_with_accessories()
    {
        $response = $this->client->products->retrieve('4060-001-04');
        $this->assertNotCount(0, $response->accessories->allItems());

        if ($response->accessories->count() > 0) {
            /**
             * @var SimpleProduct $product
             */
            $product = $response->accessories->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\SimpleProduct::class, $product);
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ProductResources\ProductPrice::class, $product->price);
        }
    }

    /**
     * @test
     * @testdox Grease Interceptor with no available optional configurations.
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
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
     * @covers \SchierProducts\SchierProductApi\Service\ProductService::retrieve
     * @covers \SchierProducts\SchierProductApi\Product
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException
     */
    public function product_with_customizations_returns_result()
    {
        $response = $this->client->products->retrieve('4055-007-02');
        $this->assertNotCount(0, $response->options->allItems());

        if ($response->options->count() > 0) {
            /**
             * @var \SchierProducts\SchierProductApi\ProductResources\ProductOption $option
             */
            $option = $response->options->first();
            $this->assertInstanceOf(\SchierProducts\SchierProductApi\ProductResources\ProductOption::class, $option);
            $this->assertIsInt($option->id);
            $this->assertIsString($option->name);
            $this->assertIsString($option->price);
        }
    }

    /**
     * @doesNotPerformAssertions
     * @return string
     */
    private static function productCc1Response() : string
    {
        return '{"object":"product","url":"\/products\/8030-003-01","name":"CC1","short_name":"CC1","type":"Clamping Collar","part_number":"8030-003-01","store_id":"129","description":"Clamping collar for units with 21\" covers, recessed and suspended. Requires riser FCR1. For use with Great Basin\u2122 models GB1, GB2 and GB3.","short_description":"Clamping collar for units with 21\" covers, recessed and suspended.","images":{"object":"product-image-library","primary":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"},"dimension":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"}},"price":{"list":"393.00","retail":{"multiplier":0.7,"price":"275.10","object":"price"},"wholesale":{"multiplier":0.55,"price":"216.15","object":"price"},"object":"product-price"},"base_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":2,"unit":"in","object":"measurement"},"width":{"value":8,"unit":"in","object":"measurement"},"height":{"value":22,"unit":"in","object":"measurement"},"weight":{"value":2,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":5.1,"unit":"cm","object":"measurement"},"width":{"value":20.3,"unit":"cm","object":"measurement"},"height":{"value":55.9,"unit":"cm","object":"measurement"},"weight":{"value":0.9,"unit":"kg","object":"measurement"}}},"shipping_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":2,"unit":"in","object":"measurement"},"width":{"value":8,"unit":"in","object":"measurement"},"height":{"value":22,"unit":"in","object":"measurement"},"weight":{"value":2,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":5.1,"unit":"cm","object":"measurement"},"width":{"value":20.3,"unit":"cm","object":"measurement"},"height":{"value":55.9,"unit":"cm","object":"measurement"},"weight":{"value":0.9,"unit":"kg","object":"measurement"}}},"related_products":[],"accessories":[],"options":[],"certifications":[{"name":"Listed by IAPMO to ANSI Z1001-2016.","link":"http:\/\/pld.iapmo.org\/file_info.asp?file_no=0011821","type":"link","object":"certification"}],"spec_sheet":{"object":"document-library","pdf":null,"dwg":null},"installation_guide":{"object":"document-library","pdf":null,"pdf_french":null,"pdf_spanish":null,"dwg":null},"revit":null,"owners_manual":null,"csi_masterspec":"http:\/\/product-api.test\/storage\/documents\/cc1\/csi-masterspec.doc"}';
    }

    /**
     * @doesNotPerformAssertions
     * @return string
     */
    private static function productGb1Response() : string
    {
        return '{"object":"product","url":"\/products\/4060-001-04","name":"GB1","short_name":"GB1","type":"Hydromechanical Grease Interceptor","part_number":"4060-001-04","store_id":"134","description":"<p>20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor<\/p><ul><li>Rugged polyethylene tank Built-in Flow Control Cartridge\u2122, easy to remove for cleaning<\/li><li>Compact design that installs under sinks, on the floor, or buried below grade<\/li><li>Built-in triple outlet for installation flexibility Includes plain end fittings to connect to 2\u201d and 3\" pipe<\/li><li>Uses FCR1 field cut riser system for a maximum extension of 25\"<\/li><\/ul>","short_description":"20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor","images":{"object":"product-image-library","primary":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"},"dimension":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"}},"price":{"list":"699.00","retail":{"multiplier":0.7,"price":"489.30","object":"price"},"wholesale":{"multiplier":0.55,"price":"384.45","object":"price"},"object":"product-price"},"installation_options":{"object":"installation-options","location":{"indoors":true,"indoors_buried":true,"outdoors":false,"outdoors_buried":false,"other":true},"location_as_text":"Indoor, Buried, On-floor, Low-Profile Under-Sink","traffic_area":false},"ratings":[{"flow_rate":{"standard":{"value":20,"unit":"GPM","object":"measurement"},"metric":{"value":1.3,"unit":"L\/s","object":"measurement"},"object":"dimension-set"},"grease_capacity":{"weight":{"standard":{"value":70,"unit":"lbs","object":"measurement"},"metric":{"value":31.7,"unit":"kg","object":"measurement"},"object":"dimension-set"},"volume":{"standard":{"value":9.59,"unit":"gal","object":"measurement"},"metric":{"value":36.3,"unit":"L","object":"measurement"},"object":"dimension-set"},"object":"grease-capacity-measurement"},"label":null,"object":"rating"}],"solids_capacity":{"standard":{"value":1.3,"unit":"gal","object":"measurement"},"metric":{"value":4.9,"unit":"L","object":"measurement"}},"liquid_capacity":{"standard":{"value":10,"unit":"gal","object":"measurement"},"metric":{"value":37.9,"unit":"L","object":"measurement"}},"base_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"shipping_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"related_products":{"object":"list","data":[{"id":2,"name":"GB1-CT","short_name":"GB1-CT","type":"Hydromechanical Grease Interceptor","part_number":"4060-101-04","store_id":"146","link":null,"price":{"list":"699.00","retail":{"multiplier":0.7,"price":"489.30","object":"price"},"wholesale":{"multiplier":0.55,"price":"384.45","object":"price"},"object":"product-price"},"object":"simple-product"}]},"accessories":{"object":"list","data":[{"component":true,"id":3,"name":"PP1","short_name":"PP1","type":"Pumpout Port","part_number":"8400-011-02","store_id":"115","link":null,"price":{"list":"166.00","retail":{"multiplier":0.7,"price":"116.20","object":"price"},"wholesale":{"multiplier":0.55,"price":"91.30","object":"price"},"object":"product-price"},"object":"simple-product"},{"component":false,"id":4,"name":"FCR1","short_name":"FCR1","type":"Riser","part_number":"8010-005-01","store_id":"199","link":null,"price":{"list":"385.00","retail":{"multiplier":0.7,"price":"269.50","object":"price"},"wholesale":{"multiplier":0.55,"price":"211.75","object":"price"},"object":"product-price"},"object":"simple-product"},{"component":false,"id":5,"name":"CC1","short_name":"CC1","type":"Clamping Collar","part_number":"8030-003-01","store_id":"129","link":null,"price":{"list":"393.00","retail":{"multiplier":0.7,"price":"275.10","object":"price"},"wholesale":{"multiplier":0.55,"price":"216.15","object":"price"},"object":"product-price"},"object":"simple-product"}]},"options":[],"certifications":[{"name":"Listed by IAPMO to ASME A112.14.3 and CSA B481.1.","link":"https:\/\/plm.iapmo.org\/pld#\/certificate\/5317\/1046","type":"link","object":"certification"}],"spec_sheet":{"object":"document-library","pdf":null,"dwg":null},"installation_guide":{"object":"document-library","pdf":null,"pdf_french":null,"pdf_spanish":null,"dwg":null},"revit":null,"owners_manual":null,"csi_masterspec":null}';
    }

    /**
     * @doesNotPerformAssertions
     * @return string
     */
    private static function productGb250Response() : string
    {
        return '{"object":"product","url":"\/products\/4055-007-02","name":"GB-250","short_name":"GB-250","type":"Hydromechanical Grease Interceptor","part_number":"4055-007-02","store_id":"261","description":"<p>20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor<\/p><ul><li>Rugged polyethylene tank Built-in Flow Control Cartridge\u2122, easy to remove for cleaning<\/li><li>Compact design that installs under sinks, on the floor, or buried below grade<\/li><li>Built-in triple outlet for installation flexibility Includes plain end fittings to connect to 2\u201d and 3\" pipe<\/li><li>Uses FCR1 field cut riser system for a maximum extension of 25\"<\/li><\/ul>","short_description":"20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor","images":{"object":"product-image-library","primary":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"},"dimension":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"product-image"}},"price":{"list":"5,955.00","retail":{"multiplier":0.7,"price":"4,168.50","object":"price"},"wholesale":{"multiplier":0.55,"price":"3,275.25","object":"price"},"object":"product-price"},"installation_options":{"object":"installation-options","location":{"indoors":true,"indoors_buried":true,"outdoors":false,"outdoors_buried":false,"other":true},"location_as_text":"Indoor, Buried, On-floor, Low-Profile Under-Sink","traffic_area":false},"ratings":[{"flow_rate":{"standard":{"value":100,"unit":"GPM","object":"measurement"},"metric":{"value":6.3,"unit":"L\/s","object":"measurement"},"object":"dimension-set"},"grease_capacity":{"weight":{"standard":{"value":1895,"unit":"lbs","object":"measurement"},"metric":{"value":859.4,"unit":"kg","object":"measurement"},"object":"dimension-set"},"volume":{"standard":{"value":259.59,"unit":"gal","object":"measurement"},"metric":{"value":982.7,"unit":"L","object":"measurement"},"object":"dimension-set"},"object":"grease-capacity-measurement"},"label":null,"object":"rating"},{"flow_rate":{"standard":{"value":200,"unit":"GPM","object":"measurement"},"metric":{"value":12.6,"unit":"L\/s","object":"measurement"},"object":"dimension-set"},"grease_capacity":{"weight":{"standard":{"value":1196,"unit":"lbs","object":"measurement"},"metric":{"value":542.4,"unit":"kg","object":"measurement"},"object":"dimension-set"},"volume":{"standard":{"value":163.84,"unit":"gal","object":"measurement"},"metric":{"value":620.2,"unit":"L","object":"measurement"},"object":"dimension-set"},"object":"grease-capacity-measurement"},"label":"4\" Pipe","object":"rating"}],"solids_capacity":{"standard":{"value":1.3,"unit":"gal","object":"measurement"},"metric":{"value":4.9,"unit":"L","object":"measurement"}},"liquid_capacity":{"standard":{"value":10,"unit":"gal","object":"measurement"},"metric":{"value":37.9,"unit":"L","object":"measurement"}},"base_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"shipping_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"options":{"object":"list","data":[{"id":1,"name":"4\" Plain End Inlet\/Outlet","price":"0.00","store_id":null,"object":"product-option"},{"id":5,"name":"6\" Plain End - Fixed Outlet","price":"0.00","store_id":null,"object":"product-option"}]},"certifications":[{"name":"Some sample file","link":"documents\/gb-250\/some-sample-file.pdf","type":"link","object":"certification"}],"spec_sheet":{"object":"document-library","pdf":"http:\/\/product-api.test\/storage\/documents\/gb-250\/spec-sheet-pdf.pdf","dwg":null},"installation_guide":{"object":"document-library","pdf":"http:\/\/product-api.test\/storage\/documents\/gb-250\/installation-guide-pdf.doc","pdf_french":null,"pdf_spanish":null,"dwg":"http:\/\/product-api.test\/storage\/documents\/gb-250\/installation-guide-dwg.txt"},"revit":null,"owners_manual":null,"csi_masterspec":"http:\/\/product-api.test\/storage\/documents\/gb-250\/csi-masterspec.doc"}';
    }
}