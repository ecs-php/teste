<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use app\Service\EmployeeService;
use app\Requests\EmployeeRequests;
use app\Exceptions\EmployeeRequestException;

class EmployeeController extends Controller
{
    
    public function listAll()
    {
        $emp = new EmployeeService();
        $list = $emp->listAll();
       
        return response()->json( $list );
    }

    public function create( EmployeeRequests $request )
    {
        try{
         
          $emp = new EmployeeService();
          $criado = $emp->create( $request );
           
        }catch( EmployeeRequestException $e){

             return response()->json( [$e->getMessage() ]  );
        }
        
        return response()->json( $criado );
    }

   
    public function item( Request $request)
    {
        $emp = new EmployeeService();
        $criado = $emp->getItem( $request->route('id') );
       
        return response()->json( $criado );
    }

     public function update( EmployeeRequests $request )
    {
        try{
        
            $emp = new EmployeeService();
            $criado = $emp->update( $request );
        
        }catch(EmployeeRequestException $e){
            return response()->json( [$e->getMessage() ]  );
        }

        return response()->json( $criado );
    }

     public function remove( Request $request )
    {
        $emp = new EmployeeService();
        $criado = $emp->remove( $request->route('id') );
       
        return response()->json( $criado );
    }
}
