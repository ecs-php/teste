<?php

namespace Provider\Service;

use Controller;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class User implements ServiceProviderInterface
{
    /**
     * @param Container $container A container instance
     */
    public function register(Container $container)
    {
        $container['controller.user'] = function () {
            return new Controller\User();
        };
    }
}
