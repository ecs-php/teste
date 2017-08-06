<?php

namespace App\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;
use App\Exception\UnauthorizedException;
use Firebase\JWT\JWT;

class Auth 
{
    public static function validateToken(Application $app, Request $request)
    {
        $rawHeader = $request->headers->get('Authorization');

        if (strpos($rawHeader, 'Bearer ') === false) {
            //return $app->json(['error' => 'Unauthorized'], 401);
            throw new UnauthorizedException('Unauthorized', 401);
        }

        $headerWithoutBearer = str_replace('Bearer ', '', $rawHeader);
        
        $superSecretKey = $app['superSecretKey'];
        
        try {
            $decodedJWT = JWT::decode($headerWithoutBearer, $superSecretKey, ['HS256']);
        }  catch (\Exception $e) {
            throw new UnauthorizedException('Unauthorized', 401);
        }

        $app['payload'] = $decodedJWT->payload;
    }
}