<?php

namespace Controller;

use AbstractControllerTest;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends AbstractControllerTest
{
    /**
     * @dataProvider invalidUserAndPasswordProvider
     * @param string $user
     * @param string $password
     */
    public function testAuthenticationFail($user, $password)
    {
        try {
            $options = [
                'body' => json_encode(['user' => $user, 'password' => $password]),
                'headers' => ['Content-Type' => 'application/json']
            ];
            $this->client->post('/auth', $options);
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
            $this->assertEquals('application/json', $e->getResponse()->getHeaders()['Content-Type'][0]);
        }
    }

    public static function invalidUserAndPasswordProvider()
    {
        return [
            ['234324', '0239842903482'],
            [getenv('USER_NAME'), '123'],
            ['lalala', getenv('USER_PASSWORD')],
        ];
    }

    public function testAuthenticationSuccess()
    {
        $options = [
            'body' => json_encode(['user' => getenv('USER_NAME'), 'password' => getenv('USER_PASSWORD')]),
            'headers' => ['Content-Type' => 'application/json']
        ];
        $response = $this->client->post('/auth', $options);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
    }
}
