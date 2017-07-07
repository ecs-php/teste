<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 20:59
 */
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

// include the prod configuration
require __DIR__ . '/production.php';

// enable the debug mode
$app['debug'] = true;
$app['driver'] = 'mysql';

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
));

$app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
));
