<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Application\Service\ServiceJsonPostRequest;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ServiceJsonPostRequestFactory
 * @package Nucleo\Service\Factory
 */
class ServiceJsonPostRequestFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ServiceJsonPostRequest(
            $container
        );
    }

}