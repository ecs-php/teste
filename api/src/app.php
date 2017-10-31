<?php

use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @var Silex\Application $app */
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());


$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../../.env');

$services = new \Rest\Services($app);
$services->bindServicesIntoContainer();

$routes = new \Rest\Routes($app);
$routes->bindRoutesToControllers();

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Authorization, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Origin');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
});

$app->match("{url}", function($url) use ($app) { return "OK"; })->assert('url', '.*')->method("OPTIONS");

$app->before(
    /**
     * @param Request $request
     *
     * @return JsonResponse|void
     */
    function (Request $request) use ($app) {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
        if ($request->getMethod() != 'OPTIONS' && $request->headers->get('Content-Type') !== 'application/json') {
            return new JsonResponse(['message' => 'Invalid request, send your request as application/json'], 400);
        }
        if ($request->getMethod() != 'OPTIONS' && !$app['users.repository']->authenticate($request)) {
            return new JsonResponse(['message' => 'Unauthorized'], 401);
        }
        return true;
    }
);

$app->error(
    /**
     * @param Exception $e
     * @param           $code
     *
     * @return JsonResponse
     */
    function (\Exception $e, $code) use ($app) {
    return new JsonResponse(
        array("statusCode" => $code, "message" => $e->getMessage())
    );
});

return $app;
