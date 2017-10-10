<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Silex\Application();
$app['debug'] = true;

$app->before([\SRS\Middlewares\AuthenticationJWT::class, 'before']);

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'    => array(
        'driver'        => DRIVER_DB,
        'host'          => HOST_DB,
        'dbname'        => NAME_DB,
        'user'          => USER_DB,
        'password'      => PASSWORD_DB,
        'charset'       => 'utf8',
        'driverOptions' => array(1002 => 'SET NAMES utf8',),
    ),
));

$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    "orm.em.options" => array(
        "mappings" => array(
            array(
                "type"      => "annotation",
                "namespace" => "SRS\Entity",
                "path"      => realpath(__DIR__."/Entitys"),
            ),
        ),
    ),
));

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

$app->error(function (\Exception $exception) use ($app) {
    return new JsonResponse([
        'message' => $exception->getMessage()
    ], Response::HTTP_OK);
});



include __DIR__ . '/routes.php';

$app->run();