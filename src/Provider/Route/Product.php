<?php

namespace Provider\Route;

use Provider\AbstractRouteProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Product extends AbstractRouteProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $this->app->get('/products', 'controller.product:index');
        $this->app->get('/products/{id}', 'controller.product:show');
        $this->app->post('/products', 'controller.product:create');
        $this->app->put('/products/{id}', 'controller.product:update');
        $this->app->delete('/products/{id}', 'controller.product:delete');
    }
}
