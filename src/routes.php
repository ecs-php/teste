<?php

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});
$app->mount( '/api/users', new Controller\UsersController());
$app->mount( '/api/registers', new Controller\RegistersController());

$app->get('/prova-html', function () use ($app) {
    return $app['twig']->render('prova.html.twig');
});
