<?php

namespace SRS\Middlewares;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class AuthenticationJWT
{
    public function before(Request $request, Application $app)
    {
        if ($request->get('_route') == 'POST_api_v1_authentication') {
            return;
        }

        list( $token ) = sscanf($request->headers->get('Authorization'), 'Bearer %s');
        if ( !$token ) {
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Unauthorized, requires token.');
        }

        $token = (new Parser())->parse((string) $token);
        $data = new ValidationData();
        $data->setId(SECURITY_KEY);

        if(!$token->validate($data)){
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Invalid token.');
        }

        $app['token'] = (string) $token;
    }
}