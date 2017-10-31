<?php

namespace Rest;

use Domain\User;
use Domain\User\UserRepository;
use Domain\Winner;
use Domain\Draw;
use Domain\Winner\WinnerRespository;
use Domain\Draw\DrawnRepository;
use Silex\Application;
use \Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Services
 *
 * @package Rest
 */
class Services
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Services constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
     */
    public function bindServicesIntoContainer()
    {
        $this->app['winners.repository'] = function () {
            $this->dbConnection();
            return new WinnerRespository(new Winner());
        };
        $this->app['draws.repository'] = function () {
            $this->dbConnection();
            return new DrawnRepository(new Draw());
        };
        $this->app['users.repository'] = function () {
            $this->dbConnection();
            return new UserRepository(new User());
        };
    }

    /**
     *
     */
    private function dbConnection()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('DOCKER_IP','10.0.75.1'),
            'database'  => getenv('MYSQL_DATABASE', 'default'),
            'username'  => getenv('MYSQL_USER', 'default'),
            'password'  => getenv('MYSQL_PASSWORD', 'secret'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}