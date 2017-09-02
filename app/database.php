<?php

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => '127.0.0.1',
        'dbname'    => 'test',
        'user'      => 'root',
        'password'  => 'root',
        'charset'   => 'utf8mb4',
    ),
));
