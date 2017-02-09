<?php

class Rest
{
    public function __construct()
    {
        print_r(explode('/', $_GET['url']));
        print_r($_SERVER['REQUEST_METHOD']);
    }
}
