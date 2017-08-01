<?php

namespace API\Middleware;

use API\Models\User;

class Authentication {

  public static function authenticate($request, $app) {

    $auth   = $request->headers->get("Authorization");
    $apikey = substr($auth, strpos($auth, ' '));
    $apikey = trim($apikey);

    $user   = new User();
    if (!$user->authenticate($apikey)) {
      $app->abort(401);
    }

  }

}
