<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once '../config/config.php';

$app = new Silex\Application([
    'debug' => true
]);

// =================================================================
// Middlewares
// =================================================================

$app->before([Middleware\Authentication::class, 'beforeRoute']);


// =================================================================
// Service providers
// =================================================================

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());
$app->register(new Provider\Service\EntityManager());
$app->register(new Provider\Service\User());
$app->register(new Provider\Service\Product());


// =================================================================
// Routes
// =================================================================

// Enable CORS
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

// Error handle
$app->error(function (\Exception $exception) use ($app) {
    return new JsonResponse([
        'message' => $exception->getMessage()
    ], Response::HTTP_OK);
});

$app->register(new Provider\Route\User($app));
$app->register(new Provider\Route\Product($app));

// =================================================================

$app->run();
