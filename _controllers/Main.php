<?php
namespace Tgenuino;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Main {
  // Simple login strategy
  static function login(Request $request, \Silex\Application $app, $user, $pass) {
    $sql = "SELECT * FROM users where user = ?";
    $user = $app['db']->fetchAssoc($sql, [$user]);

    if (($user) && ($user['password'] == md5($pass))) {
      $app['session']->set('user', $user);
      return true;
    } else return false;
  }
}

?>