<?php

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    "driver"     => $app['driver'],
    "host"       => $app['host'],
    "database"   => $app['database'],
    "username"   => $app['username'],
    "password"   => $app['password'],
    "charset"    => $app['charset'],
    "collation"  => $app['collation'],
]);

$capsule->bootEloquent();

?>