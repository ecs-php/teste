<?php

use Silex\WebTestCase;

class controllersTest extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';
        require __DIR__ . '/../config/dev.php';

        return $this->app = $app;
    }
}
