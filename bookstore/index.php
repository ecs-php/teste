<?php

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

$app = new Silex\Application();

$app['debug'] = True;

$app->register(new BookStore\Provider\AppServiceProvider());
$app->register(new BookStore\Provider\DependencyInjectionServiceProvider());

require __DIR__ . '/rotas/web.php';
require __DIR__ . '/rotas/api.php';

$app->run();
