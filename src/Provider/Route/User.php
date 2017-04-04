<?php

namespace Provider\Route;

use Provider\AbstractRouteProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class User extends AbstractRouteProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $this->app->post('/auth', 'controller.user:auth');
    }
}
