<?php

namespace Middleware;

use Lcobucci\JWT;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authentication
{
    /**
     * @param Request $request
     * @param Application $app
     */
    public function beforeRoute(Request $request, Application $app)
    {
        // Execute this middleware on all routes, except authentication
        if ($request->get('_route') == 'POST_auth') {
            return;
        }

        // Get authorization token (required)
        list($token) = sscanf($request->headers->get('Authorization'), 'Bearer %s');
        if (!$token) {
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Not authorized! Token not informed.');
        }

        // Parse token
        $token = (new JWT\Parser())->parse((string) $token);

        // Validate token
        $data = new JWT\ValidationData();
        $data->setId(getenv('SECURITY_KEY'));
        if (!$token->validate($data)) {
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Not authorized!');
        }

        // Store token on container
        $app['jwt'] = (string) $token;
    }
}
