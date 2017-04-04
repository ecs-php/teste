<?php

use PHPUnit\Framework\TestCase;

abstract class AbstractControllerTest extends TestCase
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => getenv('APP_URL')]);
    }
    
    public function tearDown() {
        $this->client = null;
    }

    /**
     * @param array $body
     * @return string
     */
    protected function getRequestOptions(array $body = null)
    {
        $options = [
            'body' => json_encode(['user' => getenv('USER_NAME'), 'password' => getenv('USER_PASSWORD')]),
            'headers' => ['Content-Type' => 'application/json']
        ];
        $response = $this->client->post('/auth', $options);

        return [
            'body' => $body ? json_encode($body) : null,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => current($response->getHeader('Authorization'))
            ]
        ];
    }
}
