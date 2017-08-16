<?php

require_once __DIR__.'/bootstrap.php';

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerFile(__DIR__.'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

$app->before(function (Request $request) {

    if (false === strpos($request->headers->get('Content-Type'), 'application/json')) {
        throw new Exception("Request not in json", 400);
    }

    $auth = $request->headers->get("Authorization");

    if (!$auth) {
        throw new Exception("Authorization was not found.", 401);
    }

    $data = json_decode($request->getContent(), true);
    $request->request->replace(is_array($data) ? $data : array());
});

$app->error(function (\Exception $e) use ($app) {
    return $app->json($e->getMessage(), $e->getCode());
});

//getting the EntityManager
$app->register(new DoctrineServiceProvider, array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'password' => '',
        'dbname' => 'serasa_test'
    )
));

$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => '/tmp/dev',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'Serasa\Model',
                'path' => __DIR__ . '/src'
            )
        )
    ),
    'orm.proxies_namespace' => 'EntityProxy',
    'orm.auto_generate_proxies' => true
));

$app->get('/', function () use ($app){
    return $app->json('Api for Tests', 200);
});

$userController = $app['controllers_factory'];

$userController->get('/', 'Serasa\Controller\UserController::list');
$userController->get('/{id}', 'Serasa\Controller\UserController::find');
$userController->post('/', 'Serasa\Controller\UserController::create');
$userController->put('/{id}', 'Serasa\Controller\UserController::update');
$userController->delete('/{id}', 'Serasa\Controller\UserController::delete');

$app->mount('/user', $userController);

$app->run();
