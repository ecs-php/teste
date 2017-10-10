<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use SRS\Controllers\PersonController;
use SRS\Controllers\AuthorizationController;

$app['person.controller'] = function () use ($app) {
    return new PersonController($app["orm.em"], $app['validator']);
};

$app['authentication.controller'] = function (){
    return new AuthorizationController();
};

$app->mount('/api', function ($api){
    $api->mount('/v1', function ($v1) {
        $v1->get('/person', 'person.controller:index');
        $v1->get('/person/{id}', 'person.controller:show');
        $v1->post('/person', 'person.controller:create');
        $v1->put('/person/{id}', 'person.controller:update');
        $v1->delete('/person/{id}', 'person.controller:delete');

        $v1->post('/authentication', 'authentication.controller:auth');
    });
});

$app->error(function (\Exception $exception) use ($app) {
    return new JsonResponse([
        'message' => $exception->getMessage()
    ], Response::HTTP_OK);
});