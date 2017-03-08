<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 20:38
 */

use \Symfony\Component\HttpFoundation\Request;
use \Silex\Application;

$api = new \Silex\Application();

$api->error(function (\Exception $exception, $request) use ($api) {
    $exceptionHandler = new \Common\Services\ExceptionHandler\ExceptionHandler();
    return $exceptionHandler->createErrorResponse($exception, \Symfony\Component\HttpFoundation\Response::HTTP_OK);
}, 666);

$api->before(function (Request $request, Application $api) {
    if ('teste' !== $request->server->get('PHP_AUTH_USER') || 'teste123' !== $request->server->get('PHP_AUTH_PW')) {
        header('WWW-Authenticate: Basic realm="Person"');
        header('HTTP/1.0 401 Unauthorized');
        header('Content-type: application/json');
        die;
    }

    if (('POST' === $request->getMethod() || 'PUT' === $request->getMethod()) &&
        'json' !== $request->getContentType()
    ) {
        throw new \Exception('Content-Type invalid for method. Only application/json is acceptable.');
    }

    $api[\Doctrine\ORM\EntityManager::class] = require_once __DIR__ . '/../config/database.php';
}, Application::EARLY_EVENT);

foreach (glob(__DIR__ . "/API/*/Resources/resources.php") as $filename) {
    require_once $filename;
}

return $api;
