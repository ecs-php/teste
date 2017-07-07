<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 21:15
 */
namespace App\Middleware;

use App\Models\User;

class Authentication {

public static function authenticate($request, $app)
{
    $auth = $request->headers->get("Authorization");
    $apikey = substr($auth, strpos($auth, ' '));
    $apikey = trim($apikey);

    $user = new User();
    $check = $user->authenticate($apikey);
    if(!$check){
        $app->abort(401);
    }
    else $request->attributes->set('user_id',$check);

    }
}
?>