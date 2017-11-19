<?php

    use \Firebase\JWT\JWT;
    
    //TOKEN MANAGEMENT
    class JWTWrapper
    {
        //KEY    
        const KEY = '7Fsxc2A865V6'; 
    
        //GENERATE NEW TOKEN
        public static function encode(array $options)
        {
            $issuedAt = time();
            $expire = $issuedAt + $options['expiration_sec'];
    
            $tokenParam = [
                'iat'  => $issuedAt,            
                'iss'  => $options['iss'],      
                'exp'  => $expire,              
                'nbf'  => $issuedAt - 1,        
                'data' => $options['userdata'], 
            ];
    
            return JWT::encode($tokenParam, self::KEY);
        }
    
        //DECODE TOKEN
        public static function decode($jwt)
        {
            return JWT::decode($jwt, self::KEY, ['HS256']);
        }
    }

?>