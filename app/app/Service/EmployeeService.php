<?php

namespace app\Service;

use app\Exceptions\EmployeeRequestException;
use app\Model\EmployeeModel;
use Illuminate\Http\Request;
use app\Requests\EmployeeRequests;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeService
{
    public function __construct()
    {
       
        $this->employee = new EmployeeModel();
    }

    public function create( EmployeeRequests $dados ){
       
        if( $dados->validate() === false ){
          throw new EmployeeRequestException( $dados->getErrorsString() );
        }

        $criado =  $this->employee::create( $dados->all() );
        
        $return = $criado->toArray();

        return [ 'employee' => [ $criado ] ];
    }
    
    public function update( EmployeeRequests $dados ){
       
        if( $dados->validate() === false ){
          throw new EmployeeRequestException( $dados->getErrorsString() );
        }
       
        $criado =  $this->employee::find( $dados->get('id') )->update( $dados->all() );
        
        $return = $this->employee::find( $dados->get('id') )->toArray();
      
        return [ 'employee' => [ $return ] ];
    }

     public function listAll(){

        $return = null;
        $return = ['employees' => $this->employee::all()->toArray()];
        return $return;

     }

     public function remove( $id ){
       
       $item =  $this->employee::find( $id )->delete();
       
        return [];

     }

     public function getItem( $id ){
        $return = null;
        $emp = $this->employee::find( $id );
        
        if(! $emp instanceof EmployeeModel){
            return [];
        }

        $return = ['employee' => $emp->toArray()];
        return $return;

     }


}
