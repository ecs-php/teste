<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Controler das funções da API
require_once APPPATH.'/controllers/API_Controller.php';

class NotFound extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->response(null, 404);
    }
}
