<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'index.php';

return ConsoleRunner::createHelperSet($em);
