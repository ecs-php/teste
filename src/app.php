<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use App\Security\TokenAuthenticator;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new SecurityServiceProvider());

$app['app.token_authenticator'] = function ($app) {
    return new TokenAuthenticator($app['security.encoder_factory']);
};

 $app['security.firewalls'] = array(
				'main' => array(
					'pattern' => '^/',
					'guard' => array(
						'authenticators' => array(
							'app.token_authenticator'
						),
					),
					'users' => array(
						// password = foo
						'admin' => array('ROLE_USER',  '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
					),
				),
			);


return $app;