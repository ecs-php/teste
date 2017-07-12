<?php

	ini_set('display_errors', 0);
	use Antomarsi\Core\Application;

	require_once __DIR__.'/../vendor/autoload.php';

	$app = new Application(false);
	$app->run();
