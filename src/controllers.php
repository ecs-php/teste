<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Middleware\Auth;
use App\Exception\UnauthorizedException;

$app->post('/api/v1/login', 'App\Controller\AuthController::login');

$app->mount('/api/v1', function ($api) use ($app) {
    
    $api->get('/wines', 'App\Controller\WineController::listAll');

    $api->get('/wines/{id}', 'App\Controller\WineController::get');

    $api->post('/wines', 'App\Controller\WineController::create');

    $api->put('/wines/{id}', 'App\Controller\WineController::update');

    $api->delete('/wines/{id}', 'App\Controller\WineController::delete');

})->before(function(Request $request) use ($app) {
    if (strpos($request->headers->get('Content-Type'), 'application/json') !== 0) {
        return $app->json(['error' => 
            'Invalid Header Content-Type (Accepts only \'application/json\')'], 400);
    }

    $data = json_decode($request->getContent(), true);

    $request->request->replace(is_array($data) ? $data : array());
    
    Auth::validateToken($app, $request);
});

$app->error(function (UnauthorizedException $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    return $app->json(['error' => $e->getMessage()], 401);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    return $app->json(['error' => 'Sorry, an error has occurred (' . 
        $e->getMessage() . ')'], $code);
});