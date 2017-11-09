<?php
require '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
 
$capsule = new Capsule();
 
$capsule->addConnection([
 
   "driver"     => "mysql",
   "host"       => "mysql",
   "database"   => "restful_api",
   "username"   => "apirest",
   "password"   => "api123456",
   "charset"    => "utf8",
   "collation"  => "utf8_general_ci"
]);
 
$capsule->bootEloquent();
 