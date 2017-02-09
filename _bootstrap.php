<?php

if(!defined('ROOT_DIR'))
    define('ROOT_DIR', dirname(__FILE__));

if(!defined('VENDOR_DIR'))
    define('VENDOR_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);

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

// $teste = array(
//     'id' => 1,
//     'name' => 'Teste',
//     'email' => 'teste@it.com'
// );
// $token = JWT::encode($teste, '12121980kcb');
//
// print_r($token);
//
// $teste = JWT::decode($token, '12121980kcb', array('HS256'));
// print_r($teste); die;
