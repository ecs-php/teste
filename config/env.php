<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 20:48
 */

if (!file_exists(dirname(__DIR__) . '/.env')) {
    throw new \Exception('You need to set up as environment variables in your .env file (see example in .env.example)');
}

$dotenv = new \Dotenv\Dotenv(dirname(__DIR__) . '/');
$dotenv->overload();

$environment = getenv('ENVIRONMENT');

$environments = ['LOCAL', 'DEVELOP', 'STAGING', 'PRODUCTION'];

if (!in_array($environment, $environments)) {
    throw new \Exception('You need to configure ENVIRONMENT in the .env file');
}

$envRequired[] = $environment . '_HOST';
$envRequired[] = $environment . '_USER';
$envRequired[] = $environment . '_PASSWORD';
$envRequired[] = $environment . '_DATABASE';
$envRequired[] = $environment . '_DEBUG';

$dotenv->required($envRequired);

if (getenv($environment . '_DEBUG') === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
