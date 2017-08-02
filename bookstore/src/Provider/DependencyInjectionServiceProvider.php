<?php

namespace BookStore\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use BookStore\Factory\ModelFactory;

class DependencyInjectionServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app) 
    {
        $app['db']->setFetchMode(\PDO::FETCH_OBJ);
        
        $app['model'] = $app->share(function ($c) {
            return new ModelFactory($c['db']);
        });
    }

    public function boot(Application $app) 
    { }
}

