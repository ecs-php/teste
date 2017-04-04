<?php

namespace Provider\Service;

use Controller;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Entity;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Service\Normalizer;
use Service\Repository;
use Symfony\Component\Serializer\Serializer;

class Product implements ServiceProviderInterface
{
    /**
     * @param Container $container A container instance
     */
    public function register(Container $container)
    {
        $container['controller.product'] = function ($container) {
            return new Controller\Product(
                $container[Repository\Product::class],
                $container[Normalizer\Product::class],
                $container[Controller\Validation\Product::class]
            );
        };

        $container[Controller\Validation\Product::class] = function () {
            return new Controller\Validation\Product();
        };

        $container[Repository\Product::class] = function ($container) {
            /** @var DoctrineEntityManager $entityManager */
            $entityManager = $container[DoctrineEntityManager::class];
            return $entityManager->getRepository(Entity\Product::class);
        };

        $container[Normalizer\Product::class] = function () {
            $normalizer = new Normalizer\Product();
            $normalizer->setSerializer(new Serializer([$normalizer]));
            return $normalizer;
        };
    }
}
