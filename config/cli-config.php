<?php

require_once __DIR__ . '/config.php';

use Symfony\Component\Console;
use Doctrine\ORM\Tools\Console as DoctrineConsole;
use Doctrine\DBAL\Tools\Console as DoctrineDBALConsole;

$container = new Pimple\Container();
$container->register(new Provider\Service\EntityManager());
$entityManager = $container[Doctrine\ORM\EntityManager::class];

$helperSet = new Console\Helper\HelperSet([
    'db' => new DoctrineDBALConsole\Helper\ConnectionHelper($entityManager->getConnection()),
    'em' => new DoctrineConsole\Helper\EntityManagerHelper($entityManager),
    'question' => new Console\Helper\QuestionHelper()
]);

$client = new Console\Application('Doctrine Command Line Interface', Doctrine\ORM\Version::VERSION);
$client->setCatchExceptions(true);
$client->setHelperSet($helperSet);

DoctrineConsole\ConsoleRunner::addCommands($client);

return $client->run();
