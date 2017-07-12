<?php

    namespace Antomarsi\Core;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Silex\Provider\AssetServiceProvider;
	use Silex\Provider\ServiceControllerServiceProvider;
	use Silex\Provider\HttpFragmentServiceProvider;
	use Silex\Provider\SecurityServiceProvider;
	use Silex\Provider\DoctrineServiceProvider;
	use Silex\Provider\MonologServiceProvider;
	
	use Antomarsi\Security\TokenAuthenticator;
	use Antomarsi\Controller;

    /**
     * Custom Class of \Silex\Application
     *
     * @author Antonio Marco da Silva <antomarsi@hotmail.com>
     */
    class Application extends \Silex\Application {

        private $config;

        public function __construct($dev = true) {
            parent::__construct();

            $this->registerServiceProviders();
            $this->registerSecurityFirewalls();
			$this->loadProdConfig();
            if ($dev) {
                $this->loadDevConfig();
            }
            $this->registerRoutes();
        }

        private function registerServiceProviders() {
			$this->register(new ServiceControllerServiceProvider());
			$this->register(new AssetServiceProvider());
			$this->register(new HttpFragmentServiceProvider());
			$this->register(new SecurityServiceProvider());
			$this['app.token_authenticator'] = function ($app) {
				return new TokenAuthenticator($app['security.encoder_factory']);
			};
			$this->register(new DoctrineServiceProvider(), array(
				'db.options' => array(
					'driver'   => 'pdo_mysql',
					'host'      => 'localhost',
					'dbname'    => 'ecs',
					'user'      => 'root',
					'password'  => '',
					'charset'   => 'utf8mb4',
				),
			));
			
        }
		// Normally this will load the TWIG config, but twig is not needed in a API only system
        public function loadProdConfig() {
            			
        }

        public function loadDevConfig() {
			$this['debug'] = true;

			$this->register(new MonologServiceProvider(), array(
				'monolog.logfile' => __DIR__.'/../../var/logs/silex_dev.log',
			));
        }

        private function registerSecurityFirewalls() {
            $this['security.firewalls'] = array(
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
        }

        private function registerRoutes() {
			$this->mount('/user', new Controller\UserController);
        }

    }
    