<?php

require  __DIR__ . '/config/config.php';

$paths = [
    __DIR__ . '/src/Entitys'
];
$isDevMode = true;
$dbParams = [
    'driver' => DRIVER_DB,
    'user' => USER_DB,
    'password' => PASSWORD_DB,
    'dbname' => NAME_DB
];
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths,$isDevMode);
$entityManager = \Doctrine\ORM\EntityManager::create($dbParams,$config);
function getEntityManager(){
    global $entityManager;
    return $entityManager;
}

$entityManager = getEntityManager();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);