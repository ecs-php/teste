<?php

    namespace Antomarsi\Core;

    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputOption;
	use Doctrine\DBAL\Schema\Table;
    use Antomarsi\Core\Application as App;

    /**
     * Custom console class
     *
     * @author Antonio Marco da Silva <antomarsi@hotmail.com>
     */
    class Console extends \Symfony\Component\Console\Application {

        public function __construct(App $app, $name = 'UNKNOWN', $version = 'UNKNOWN') {
            parent::__construct($name, $version);
            $this->setEnvOpt($app);
            $this->registerDB($app);
        }

        private function setEnvOpt(App $app) {
            $this->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
            $this->setDispatcher($app['dispatcher']);
        }

        private function registerDB(App $app) {
            $this->register('db:create')
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
					$output->writeln(sprintf("%s - <info>Table users created</info>", 'db:create'));
					
					$output->writeln(sprintf("%s - <info>Database created succefully</info>", 'db:create'));
				});

			$this->register('db:seed')
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
					$output->writeln(sprintf("%s - <info>Table User seeded</info>", 'db:seed'));
				}
				$output->writeln(sprintf("%s - <info>Database seeded Succefully</info>", 'db:seed'));
			});
        }
    }    