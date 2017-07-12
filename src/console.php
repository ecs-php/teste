<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

use Faker\Factory as FakerFactory;
use App\Model\Person;

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

		Capsule::schema()->dropIfExists('person');
        Capsule::schema()->create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->date('date_birth');
			$table->longText('address')->nullable();
            $table->timestamps();
        });
    });

$console
	->register('db:seed')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('Seed the tables')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
		$faker = FakerFactory::create('pt_BR');
		if(Capsule::schema()->hasTable('person')){
			for ($i=0; $i < 10; $i++) { 
				$person = new Person();
				$person->name = $faker->name;
				$person->email = $faker->email;
				$person->date_birth = $faker->dateTimeThisCentury->format('Y-m-d');
				$person->address = $faker->streetAddress;
				$person->save();
			}
		}
	});

return $console;
