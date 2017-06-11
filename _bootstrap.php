<?php

if(!defined('ROOT_DIR'))
    define('ROOT_DIR', dirname(__FILE__));

if(!defined('VENDOR_DIR'))
    define('VENDOR_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);

if(!defined('API_JWT_SECRET'))
    define('API_JWT_SECRET', '12121980kcb');

// Composer
require VENDOR_DIR . 'autoload.php';

function recursive_autoloader($class, $path=ROOT_DIR)
{
    $di = new DirectoryIterator($path);

    foreach($di as $item) {
        if($item->isDot())
            continue;

        if($item->isDir())
            recursive_autoloader($class, $item->getPathname() . DIRECTORY_SEPARATOR);
    }

    $class_file = $path . "{$class}.class.php";

    if(file_exists($class_file)) {
        require_once $class_file;
    }
}
spl_autoload_register('recursive_autoloader');
