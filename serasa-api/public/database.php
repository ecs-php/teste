<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection([
    "driver"    => "mysql",
    "host"      => "localhost",
    "database"  => "serasa_api",
    "username"  => "root",
    "password"  => "gj123",
    "charset"   => "utf8",
    "collation" => "utf8_general_ci",
    "prefix"    => ""
]);

$capsule->bootEloquent();
