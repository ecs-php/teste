<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Users;

class GenericController extends Controller
{
    //


    public function noRoute(){
    	#dd(env('DB_DATABASE'))     ;          // => 'database/database.sqlite'
		#dd(database_path('database.sqlite')); // => 'D:\www\project\database\database.sqlite'

		$usuarios = Users::all();
    	dd($usuarios);
    	$result = [
    		'success'=>false,
    		'message'=>'Nenhuma rota acionada.'
    	];


		return response()->json($result);


    }
}
