<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 20:00
 */
ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__ . '/../config/production.php';
include  __DIR__.'/../bootstrap.php';

require __DIR__.'/../src/controllers.php';
$app->run();
