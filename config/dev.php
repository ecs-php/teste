<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

require __DIR__ . '/production.php';

$app['debug'] = true;