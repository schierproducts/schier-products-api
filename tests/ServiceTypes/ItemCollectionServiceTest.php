<?php


namespace SchierProducts\SchierProductApi\Tests\ServiceTypes;


use SchierProducts\SchierProductApi\ItemCollection;
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

        $factory = new \Illuminate\Http\Client\Factory();
        $factory->fake([
            SchierProductApi::$apiBase.'/collections' => \Illuminate\Http\Client\Factory::response(self::collectionListResponse()),
//            SchierProductApi::$apiBase.'/collections/gb1' => \Illuminate\Http\Client\Factory::response(self::productCc1Response()),
        ]);
        SchierProductApi::setHttpClient($factory);
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
     * @return string
     */
    public static function collectionListResponse() : string
    {
        return '{"object":"list","url":"\/collections","data":[{"object":"collection","url":"\/collections\/gb-1","name":"GB-1","key":"gb-1","size":2,"image":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"image-library"},"items":{"object":"list","data":[{"object":"product","url":"\/products\/4060-001-04","name":"GB1","short_name":"GB1","type":"Hydromechanical Grease Interceptor","part_number":"4060-001-04","store_id":"134","description":"<p>20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor<\/p><ul><li>Rugged polyethylene tank Built-in Flow Control Cartridge\u2122, easy to remove for cleaning<\/li><li>Compact design that installs under sinks, on the floor, or buried below grade<\/li><li>Built-in triple outlet for installation flexibility Includes plain end fittings to connect to 2\u201d and 3\" pipe<\/li><li>Uses FCR1 field cut riser system for a maximum extension of 25\"<\/li><\/ul>","short_description":"20\/25 GPM Great Basin\u2122 Indoor High Capacity Grease Interceptor","images":{"object":"product-image-library","primary":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"image-library"},"dimension":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"image-library"}},"price":{"list":"699.00","retail":{"multiplier":0.7,"price":"489.30","object":"price"},"wholesale":{"multiplier":0.55,"price":"384.45","object":"price"},"object":"product-price"},"installation_options":{"object":"installation-options","location":{"object":"installation-options-location","indoors":true,"indoors_buried":true,"outdoors":false,"outdoors_buried":false,"other":true},"location_as_text":"Indoor, Buried, On-floor, Low-Profile Under-Sink","traffic_area":false},"ratings":[{"flow_rate":{"standard":{"value":20,"unit":"GPM","object":"measurement"},"metric":{"value":1.3,"unit":"L\/s","object":"measurement"},"object":"dimension-set"},"grease_capacity":{"weight":{"standard":{"value":70,"unit":"lbs","object":"measurement"},"metric":{"value":31.7,"unit":"kg","object":"measurement"},"object":"dimension-set"},"volume":{"standard":{"value":9.59,"unit":"gal","object":"measurement"},"metric":{"value":36.3,"unit":"L","object":"measurement"},"object":"dimension-set"},"object":"grease-capacity-measurement"},"label":null,"object":"rating"}],"solids_capacity":{"standard":{"value":1.3,"unit":"gal","object":"measurement"},"metric":{"value":4.9,"unit":"L","object":"measurement"},"object":"dimension-set"},"liquid_capacity":{"standard":{"value":10,"unit":"gal","object":"measurement"},"metric":{"value":37.9,"unit":"L","object":"measurement"},"object":"dimension-set"},"base_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"shipping_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"options":{"object":"list","data":[]},"certifications":[{"name":"Listed by IAPMO to ASME A112.14.3 and CSA B481.1.","link":"https:\/\/plm.iapmo.org\/pld#\/certificate\/5317\/1046","type":"link","object":"certification"}],"spec_sheet":{"object":"document-library","pdf":null,"dwg":null},"installation_guide":{"object":"document-library","pdf":null,"pdf_french":null,"pdf_spanish":null,"dwg":null},"revit":null,"owners_manual":null,"csi_masterspec":null},{"object":"product","url":"\/products\/4060-101-04","name":"GB1-CT","short_name":"GB1-CT","type":"Hydromechanical Grease Interceptor","part_number":"4060-101-04","store_id":"146","description":"<p>15 GPM Great Basin\u2122 Indoor Super-Capacity Grease Interceptor<\/p><ul><li>Rugged polyethylene tank Built-in Flow Control Cartridge\u2122, easy to remove for cleaning<\/li><li>Compact design that installs under sinks, on the floor, or buried below grade<\/li><li>Built-in triple outlet for installation flexibility<\/li><li>Includes fittings to connect to 2,\u201d 3\", or 4\" pipe<\/li><li>Uses FCR1 field cut riser system for a maximum extension of 25\"<\/li><\/ul>","short_description":"15 GPM Great Basin\u2122 Indoor Super-Capacity Grease Interceptor","images":{"object":"product-image-library","primary":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"image-library"},"dimension":{"orig":"http:\/\/product-api.test\/img\/no-image.png","lg":"http:\/\/product-api.test\/img\/no-image_lg.png","md":"http:\/\/product-api.test\/img\/no-image_md.png","sm":"http:\/\/product-api.test\/img\/no-image_sm.png","object":"image-library"}},"price":{"list":"699.00","retail":{"multiplier":0.7,"price":"489.30","object":"price"},"wholesale":{"multiplier":0.55,"price":"384.45","object":"price"},"object":"product-price"},"installation_options":{"object":"installation-options","location":{"object":"installation-options-location","indoors":true,"indoors_buried":true,"outdoors":false,"outdoors_buried":false,"other":true},"location_as_text":"Indoor, Buried, On-floor, Low-Profile Under-Sink","traffic_area":false},"ratings":[{"flow_rate":{"standard":{"value":15,"unit":"GPM","object":"measurement"},"metric":{"value":0.9,"unit":"L\/s","object":"measurement"},"object":"dimension-set"},"grease_capacity":{"weight":{"standard":{"value":70,"unit":"lbs","object":"measurement"},"metric":{"value":31.7,"unit":"kg","object":"measurement"},"object":"dimension-set"},"volume":{"standard":{"value":9.59,"unit":"gal","object":"measurement"},"metric":{"value":36.3,"unit":"L","object":"measurement"},"object":"dimension-set"},"object":"grease-capacity-measurement"},"label":null,"object":"rating"}],"solids_capacity":{"standard":{"value":1.3,"unit":"gal","object":"measurement"},"metric":{"value":4.9,"unit":"L","object":"measurement"},"object":"dimension-set"},"liquid_capacity":{"standard":{"value":10,"unit":"gal","object":"measurement"},"metric":{"value":37.9,"unit":"L","object":"measurement"},"object":"dimension-set"},"base_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"shipping_dimensions":{"object":"dimension-set","standard":{"object":"dimensions","length":{"value":23,"unit":"in","object":"measurement"},"width":{"value":27,"unit":"in","object":"measurement"},"height":{"value":12,"unit":"in","object":"measurement"},"weight":{"value":39,"unit":"lbs","object":"measurement"}},"metric":{"object":"dimensions","length":{"value":58.4,"unit":"cm","object":"measurement"},"width":{"value":68.6,"unit":"cm","object":"measurement"},"height":{"value":30.5,"unit":"cm","object":"measurement"},"weight":{"value":17.7,"unit":"kg","object":"measurement"}}},"options":{"object":"list","data":[]},"certifications":[],"spec_sheet":{"object":"document-library","pdf":null,"dwg":null},"installation_guide":{"object":"document-library","pdf":null,"pdf_french":null,"pdf_spanish":null,"dwg":null},"revit":null,"owners_manual":null,"csi_masterspec":null}]}}]}';
    }
}