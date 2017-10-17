<?php

namespace Serasa;

use \Firebase\JWT\JWT;

class JWTWrapper
{
    const KEY = '123qaz456WSX';

    public static function encode(array $options)
    {
        $dateTimeNow = new \DateTime();
        $issuedAt = $dateTimeNow->format('Y-m-d H:i:s');
        $notValidBeforeAt = ($dateTimeNow->sub(new \DateInterval('PT1S')))
            ->format('Y-m-d H:i:s');
        $expireAt = ($dateTimeNow->add(new \DateInterval('PT'. $options['expiration'] . 'S')))
            ->format('Y-m-d H:i:s');
        $tokenParams = [
            'issuedAt'  => $issuedAt,
            'domain'  => $options['domain'],
            'expireAt'  => $expireAt,
            'notValidBeforeAt'  => $notValidBeforeAt,
            'optionData' => $options['userData'],
        ];
        return JWT::encode($tokenParams, self::KEY);
    }

    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::KEY, ['HS256']);
    }
}