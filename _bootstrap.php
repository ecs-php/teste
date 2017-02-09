<?php

if(!defined('CLASS_PATH'))
    define('CLASS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR);

function __autoload($class)
{
    $class_file = CLASS_PATH . "{$class}.class.php";

    if(file_exists($class_file)) {
        require_once $class_file;
    }
}
