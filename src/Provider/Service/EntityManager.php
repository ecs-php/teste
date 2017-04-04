<?php

namespace Provider\Service;

use Doctrine\Common;
use Doctrine\ORM;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EntityManager implements ServiceProviderInterface
{
    /**
     * @param Container $container A container instance
     */
    public function register(Container $container)
    {
        $cache = getenv('APP_ENV') == 'production' ? new Common\Cache\ApcuCache() : new Common\Cache\ArrayCache();

        $config = new ORM\Configuration;
        $config->setQueryCacheImpl($cache);
        $config->setMetadataCacheImpl($cache);
        $config->setProxyDir(CONFIG_DIR . 'storage/cache/doctrine');
        $config->setProxyNamespace('EntityProxy');
        $config->setAutoGenerateProxyClasses(Common\Proxy\AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);
        $config->setMetadataDriverImpl(new ORM\Mapping\Driver\SimplifiedYamlDriver([
            CONFIG_DIR . 'src/Mapping' => 'Entity'
        ]));

        $container[ORM\EntityManager::class] = ORM\EntityManager::create(
            [
                'driver' => getenv('DATABASE_DRIVER'),
                'path' => CONFIG_DIR . getenv('DATABASE_PATH'),
                'charset' => 'utf8',
            ],
            $config
        );
    }
}
