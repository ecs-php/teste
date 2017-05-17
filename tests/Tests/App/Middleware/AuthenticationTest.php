<?php

namespace Test\App\Middleware;

use App\Middleware\Authentication;
use PHPUnit\Framework\TestCase;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationTest extends TestCase
{
    public function testShouldAuthenticate()
    {
        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'admin');
        $request->headers->set('PHP_AUTH_PW', '456');

        $app = new Application();
        $app['app.http.basic'] = array(
            'admin' => '456'
        );

        $authentication = new Authentication();
        $result = $authentication($request, $app);

        $this->assertNull($result);
    }

    public function testShouldNotAuthenticate()
    {
        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'admin');
        $request->headers->set('PHP_AUTH_PW', '456');

        $app = new Application();
        $app['app.http.basic'] = array(
            'admin' => '4567'
        );

        $authentication = new Authentication();

        $result = $authentication($request, $app);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $result->getStatusCode());
    }

    public function testShouldSkipAuthenticationWhenConfigIsNotDefined()
    {
        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'admin');
        $request->headers->set('PHP_AUTH_PW', '456');

        $app = new Application();

        $authentication = new Authentication();

        $result = $authentication($request, $app);

        $this->assertNull($result);
    }

}