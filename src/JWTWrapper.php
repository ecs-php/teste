<?php
use \Firebase\JWT\JWT;

/**
 * Gerenciamento de tokens JWT
 */
class JWTWrapper
{
    const KEY = '1A2B3c4d5e'; // chave

    /**
     * Geracao de um novo token jwt
     */
    public static function encode(array $options)
    {
        $issuedAt = time();
        $expire = $issuedAt + $options['expiration_sec'];

        $tokenParam = [
            'iat'  => $issuedAt,
            'exp'  => $expire,
            'nbf'  => $issuedAt - 1,
            'data' => $options['userdata'],
        ];

        return JWT::encode($tokenParam, self::KEY);
    }

    /**
     * Decodifica token jwt
     */
    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::KEY, ['HS256']);
    }
}