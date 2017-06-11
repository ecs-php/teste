<?php
use Symfony\Component\Debug\Debug;
//ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

Debug::enable();
$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
