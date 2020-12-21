<?php


namespace SchierProducts\SchierProductApi;


/**
 * Class ApiResponse.
 */
class ApiResponse
{
    /**
     * @var null|array
     */
    public $headers;

    /**
     * @var string
     */
    public $body;

    /**
     * @var null|array
     */
    public $json;

    /**
     * @var int
     */
    public $code;

    /**
     * @param string $body
     * @param int $code
     * @param null|array $headers
     * @param null|array $json
     */
    public function __construct(string $body, int $code, ?array $headers = null, ?array $json = null)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->json = $json;
    }
}
