<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 21:29
 */

$entityManager = require_once 'database.php';

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager),
    'dialog' => new \Symfony\Component\Console\Helper\QuestionHelper()
);

$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', Doctrine\Common\Version::VERSION);
$cli->setCatchExceptions(true);

$helperSet = $cli->getHelperSet();

foreach ($helpers as $name => $helper) {
    $helperSet->set($helper, $name);
}

$cli->addCommands(array(
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand()
));

$cli->run();
