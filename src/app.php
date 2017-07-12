<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Antomarsi\Security\TokenAuthenticator;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new SecurityServiceProvider());

$app['app.token_authenticator'] = function ($app) {
    return new TokenAuthenticator($app['security.encoder_factory']);
};

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'ecs',
        'user'      => 'root',
        'password'  => '',
        'charset'   => 'utf8mb4',
    ),
));

$app['security.firewalls'] = array(
    'main' => array(
        'pattern' => '^/user',
        'guard' => array(
            'authenticators' => array(
                'app.token_authenticator'
            ),
        ),
        'users' => array(
            // password = foo
            'admin' => array('ROLE_USER',  '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
        ),
    ),
);

return $app;
