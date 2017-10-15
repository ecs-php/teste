<?php
namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceDoctrine
 * @package Nucleo\Service
 */
class ServiceDoctrine
{

    private $objEntityManager;

    /**
     * @param ServiceLocatorInterface|null $objServiceLocator
     * @return EntityManager
     */
    public function getObjEntityManager(
        ServiceLocatorInterface $objServiceLocator = null
    ) {
        if ($objServiceLocator != null && $this->objEntityManager == null) {
            $this->objEntityManager = $objServiceLocator->get(EntityManager::class);
        }
        return $this->objEntityManager;
    }

    /**
     * Função implementada de FactoryInterface
     * Cria o serviço do doctrine
     * @param ServiceLocatorInterface $objServiceLocator
     * @return EntityManager
     */
    public function createService(
        ServiceLocatorInterface $objServiceLocator
    ) {
        return $this->getObjEntityManager(
            $objServiceLocator
        );
    }

    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return EntityManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->getObjEntityManager(
            $container
        );
    }
}
