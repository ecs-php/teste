<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

if (DEBUG_ENVIRONMENT) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $app['debug'] = true;
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../src/router.php';


$app->run();
