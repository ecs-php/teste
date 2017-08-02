<?php

namespace BookStore\Controllers;

use Silex\Application;

class WebController {

    function index(Application $app) {
        $list['books'] = $app['model']->create('Book')->getAll();
        return $app['twig']->render('books.twig', $list);
    }

}
