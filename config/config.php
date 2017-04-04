<?php

require __DIR__ . '/../vendor/autoload.php';

// =================================================================
// Environment Variables
// =================================================================

if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = new \Dotenv\Dotenv(dirname(__DIR__) . '/');
    $dotenv->overload();
    $dotenv->required([
        'APP_ENV',
        'APP_PATH',
        'DATABASE_DRIVER',
        'DATABASE_PATH'
    ]);
}

// =================================================================
// Settings
// =================================================================

define('CONFIG_PATH', getenv('APP_PATH'));
define('CONFIG_DIR', dirname(__DIR__) . '/');
