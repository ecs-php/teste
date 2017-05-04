<?php

require_once './vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


//$dsn = __DIR__.DIRECTORY_SEPARATOR.'baseDados.sqlite3';
$dsn = __DIR__.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'store.db';
$paths = array(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Entity');
$isDevMode = false;

$dbParams = array(
    'driver'   => 'pdo_sqlite',
    'path'   => $dsn,
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);

//dump($em);

$app = new Silex\Application();
$app['debug'] = true;
$app->mount("/", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."BaseController.php");
$app->mount("/users", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."UserController.php");
$app->mount("/products", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."ProductController.php");

$app->run();