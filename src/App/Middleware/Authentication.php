<?php

namespace App\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{
    public function __invoke(Request $request, Application $app) {

        if (!isset($app['app.http.basic'])) {
            return;
        }

        $user = $request->getUser();
        $password = $request->getPassword();
        $isAuthenticated = isset($app['app.http.basic'][$user]) && $app['app.http.basic'][$user] == $password;
        if (!$isAuthenticated) {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }
    }
}