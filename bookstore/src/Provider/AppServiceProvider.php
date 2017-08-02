<?php

namespace BookStore\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app) 
    {
        $app->register(new \Silex\Provider\TwigServiceProvider(), [
            'twig.path' => __DIR__ . '/../../views'
        ]);
        $app->register(new DoctrineServiceProvider, [
            'db.options' => [
                'driver'    => 'pdo_mysql',
                'host'      => 'localhost',
                'dbname'    => 'bookstore',
                'user'      => 'root',
                'password'  => '',
                'charset'   => 'utf8mb4',
            ]
        ]);
    }

    public function boot(Application $app) 
    { }
}

