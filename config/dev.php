<?php

use Silex\Provider\MonologServiceProvider;

require __DIR__.'/prod.php';

$app['debug'] = true;
$app['db.options'] = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../var/sqlite/book_store_dev.db',
);

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
));