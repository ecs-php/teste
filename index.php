<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/_controllers/Main.php';
require_once __DIR__.'/_controllers/Task.php';
require_once __DIR__.'/_controllers/Serasa.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;

$isAuth = function (Request $request) use ($app) {
  if (null === $user = $app['session']->get('user')) {
    return $app->redirect('./login');
  }
};

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
      'dbname' => 'tgenuino_php_test',
      'driver'   => 'pdo_mysql'
    ),
));

// Login routes
$app->get('/login', function () use ($app) {
  return $app->stream(function () {
    readfile('_views/login.html');
  }, 200, array('Content-Type' => 'text/html'));
});

$app->post('/login', function (Request $request) use ($app) {
  $check = \Tgenuino\Main::login($request, $app, $request->request->get('user'), $request->request->get('password'));

  if ($check === true) {
    return $app->redirect('./');
  } else {
    return $app->redirect('./login');
  }
});

// Home route
$app->get('/', function () use ($app) {
  return $app->stream(function () {
    readfile('_views/home.html');
  }, 200, array('Content-Type' => 'text/html'));
})->before($isAuth);

$app->get('/serasa', function () use ($app) {
  return $app->stream(function () {
    readfile('_views/serasa.html');
  }, 200, array('Content-Type' => 'text/html'));
});

// API routes
$app->mount('/api', include __DIR__.'/_routes/api.php');

$app->run();