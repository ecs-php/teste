<?php

namespace Rest;

use Rest\Controllers\DrawsController;
use Rest\Controllers\WinnersController;
use Silex\Application;

/**
 * Class Routes
 *
 * @package Rest
 */
class Routes
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Routes constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    /**
     *
     */
    private function instantiateControllers()
    {
        $this->app['winners.controller'] = function () {
            return new WinnersController($this->app['winners.repository']);
        };
        $this->app['draws.controller'] = function () {
            return new DrawsController($this->app['draws.repository']);
        };
    }

    /**
     *
     */
    public function bindRoutesToControllers()
    {
        $winners = $this->app["controllers_factory"];
        $winners->get('/winners', "winners.controller:list");
        $winners->get('/winners/{id}', "winners.controller:find");
        $winners->post('/winners', "winners.controller:save");
        $winners->put('/winners/{id}', "winners.controller:update");
        $winners->delete('/winners/{id}', "winners.controller:delete");
        $this->app->mount('/', $winners);

        $draws = $this->app["controllers_factory"];
        $draws->get('/draws', "draws.controller:list");
        $draws->get('/draws/{id}', "draws.controller:find");
        $draws->post('/draws', "draws.controller:save");
        $draws->put('/draws/{id}', "draws.controller:update");
        $draws->delete('/draws/{id}', "draws.controller:delete");
        $this->app->mount('/', $draws);
    }
}
