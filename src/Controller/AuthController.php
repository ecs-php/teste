<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Firebase\JWT\JWT;

class AuthController
{
    public function login(Application $app, Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        if ($username != 'experian' || $password != 'serasa') {
            return $app->json(['error' => 'Unauthorized. Invalid user credentials'], 401);
        }

        $jsonObject = [
            "iss" => "reginaldorubens",
            "aud" => "http://github.com/reginaldorubens/teste",
            "iat" => time(), // Issued At Time
            "nbf" => time(), // Not Before Time
            "exp" => time()+60*60*24, // Expiration Time (24 hours)
            "payload" => [
                "firstName" => "Reginaldo",
                "lastName" => "Silva",
                "title" => "Fullstack Developer",
                "admin" => true
            ]
        ];

        $superSecretKey = $app['superSecretKey'];
        
        $jsonWebToken = JWT::encode($jsonObject, $superSecretKey);

        return $app->json(['token' =>  $jsonWebToken], 200);
    }
}