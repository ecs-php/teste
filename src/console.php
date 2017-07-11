<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\DBAL\Schema\Table;

$console = new Application('My Silex Application', 'n/a');
$console->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
$console->setDispatcher($app['dispatcher']);
$console
    ->register('update-db')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('My command description')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
			if (!$schema->tablesExist('users'))
	{
		$users = new Table('users');
		$users->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
		$users->setPrimaryKey(array('id'));
		$users->addColumn('username', 'string', array('length' => 32));
		$users->addUniqueIndex(array('username'));
		$users->addColumn('password', 'string', array('length' => 255));
    })
;

return $console;
