<?php

namespace SRS\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lcobucci\JWT\Builder;

class AuthorizationController
{

    public function auth(Request $request)
    {
        $payload = json_decode($request->getContent());
        $user = $payload->user;
        $password = $payload->password;

        if($user != ACCESS_USER OR $password != ACCESS_PASS){
            return new JsonResponse([ "error" => "Username or password is invalid" ], Response::HTTP_UNAUTHORIZED);
        }

        $token = (new Builder())
            ->setId(SECURITY_KEY, true)
            ->setExpiration(time() + 3600)
            ->getToken();
        return new JsonResponse([ "token" => (string) $token ], Response::HTTP_CREATED);

    }


}