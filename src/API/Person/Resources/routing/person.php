<?php
/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:45
 */

use \Symfony\Component\HttpFoundation\Request;

$api->get('/person', function (Request $request) use ($api) {
    /** @var Person\Services\Controller\PersonController $PersonController */
    $PersonController = $api[\Person\Services\Controller\PersonController::class];

    return $PersonController->get($request);
});

$api->get('/person/{id}', function (Request $request) use ($api) {
    /** @var Person\Services\Controller\PersonController $PersonController */
    $PersonController = $api[\Person\Services\Controller\PersonController::class];

    return $PersonController->getById($request);
});

$api->post('/person', function (Request $request) use ($api) {
    /** @var Person\Services\Controller\PersonController $PersonController */
    $PersonController = $api[\Person\Services\Controller\PersonController::class];

    return $PersonController->post($request);
});

$api->put('/person', function (Request $request) use ($api) {
    /** @var Person\Services\Controller\PersonController $PersonController */
    $PersonController = $api[\Person\Services\Controller\PersonController::class];

    return $PersonController->put($request);
});

$api->delete('/person/{id}', function (Request $request) use ($api) {
    /** @var Person\Services\Controller\PersonController $PersonController */
    $PersonController = $api[\Person\Services\Controller\PersonController::class];

    return $PersonController->delete($request);
});
