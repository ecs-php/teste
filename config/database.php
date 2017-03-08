<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 21:02
 */

use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use \Doctrine\ORM\EntityManager;

require_once 'env.php';

$defaultConfig = new Configuration();
$defaultConfig->setProxyDir(__DIR__ . '/../data/Proxy');
$defaultConfig->setProxyNamespace('Proxy');

$driver = new SimplifiedYamlDriver([
    __DIR__ . '/../src/API/Person/Entity/Mapping' => 'Person\Entity',
]);

$defaultConfig->setMetadataDriverImpl($driver);

$entityManager = EntityManager::create(
    [
        'driver' => 'pdo_mysql',
        'host' => getenv(getenv('ENVIRONMENT') . '_HOST'),
        'port' => '3306',
        'user' => getenv(getenv('ENVIRONMENT') . '_USER'),
        'password' => getenv(getenv('ENVIRONMENT') . '_PASSWORD'),
        'dbname' => getenv(getenv('ENVIRONMENT') . '_DATABASE'),
        'charset' => 'utf8',
    ],
    $defaultConfig
);

return $entityManager;
