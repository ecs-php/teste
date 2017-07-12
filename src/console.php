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
	->register('db:create')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('Create the tables')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
		$schema = $app['db']->getSchemaManager();
		if ($schema->tablesExist('users')){
			$schema->dropTable('users');
		}

			$users = new Table('users');
			$users->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
			$users->setPrimaryKey(array('id'));
			$users->addColumn('name', 'string', array('length' => 255));
			$users->addColumn('email', 'string', array('length' => 255));
			$users->addColumn('date_birth', 'date');
			$users->addColumn('address', 'text');
			$users->addColumn('created_at', 'datetime');
			$users->addColumn('updated_at', 'datetime');
			$schema->createTable($users);
    });

$console
	->register('db:seed')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('Seed the tables')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
		$faker = \Faker\Factory::create('pt_BR');
		$schema = $app['db']->getSchemaManager();
		if ($schema->tablesExist('users')){
			for ($i=0; $i < 10; $i++) { 
				$app['db']->insert('users', array(
					'name' => $faker->name,
					'email' => $faker->email,
					'date_birth' => $faker->dateTimeThisCentury->format('Y-m-d'),
					'address' => $faker->streetAddress,
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
					));
			}
		}   });

return $console;
