<?php

require_once './vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$dsn = __DIR__.DIRECTORY_SEPARATOR.'store.sqlite3';
$paths = array(DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Entity');
$isDevMode = false;

$dbParams = array(
    'driver'   => 'pdo_sqlite',
    'src'   => $dsn,
);
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);


$app = new Silex\Application();

$app->mount("/", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."BaseController.php");
$app->mount("/users", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."UserController.php");
$app->mount("/products", include "src".DIRECTORY_SEPARATOR."Route".DIRECTORY_SEPARATOR."ProductController.php");

$app->run();