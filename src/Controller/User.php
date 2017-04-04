<?php

namespace Controller;

use Controller\Exception\InvalidArgumentHttpException;
use Lcobucci\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class User
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function auth(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($data['user'] == getenv('USER_NAME') && $data['password'] == getenv('USER_PASSWORD')) {
            $token = (new JWT\Builder())
                ->identifiedBy(getenv('SECURITY_KEY'), true)
                ->expiresAt(time() + 3600) // Expiration = 1 Hour
                ->getToken();
            return new JsonResponse(
                ['user' => getenv('USER_NAME'), 'token' => (string) $token],
                JsonResponse::HTTP_CREATED,
                ['Authorization' => 'Bearer ' . (string) $token]
            );
        }
        throw new InvalidArgumentHttpException('Invalid user or password', JsonResponse::HTTP_UNAUTHORIZED);
    }
}
