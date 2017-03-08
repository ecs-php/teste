<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 20:15
 */

setlocale(LC_ALL, "pt_BR.utf-8", "pt_BR", "portuguese", "pt_BR.iso-8859-1");
date_default_timezone_set('America/Sao_Paulo');

$loader = require_once __DIR__.'/../vendor/autoload.php';

/** @var \Silex\Application $api */
$api = require_once __DIR__ . '/../src/api.php';

$api->run();
