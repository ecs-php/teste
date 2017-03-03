<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiControllerTrait;
use App\Client;

class ClientController extends Controller
{

    use ApiControllerTrait;
    protected $model;
    protected $relationships = [];

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

}
