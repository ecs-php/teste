<?php

use Silex\Provider\MonologServiceProvider;

$app['app.http.basic'] = array(
    'admin' => 123
);

$app['db.options'] = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../var/sqlite/book_store.db',
);

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../var/logs/silex.log',
));
