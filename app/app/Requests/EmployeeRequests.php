<?php

namespace app\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Validator;

class EmployeeRequests extends FormRequest
{
    private $validator;
  
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
                    'name' => 'required|min:3',
                    'email' => 'required|min:3',
                    'address' => 'required|min:6',
                    'number' => 'required|min:1',
                    'phone' => 'required|numeric',
                    'cpf' => 'required|numeric',
                ];
    }

    public function messages(){
        return [
            'required' => 'Fied :attribute not is optional',
        ];
    }

  
    public function validate()
    {
           $this->validator = Validator::make(parent::validationData(), 
                            $this->rules()
               );

            return  (!$this->validator->fails() );
    }

    public function isValid()
    {
        return (!$this->validator->fails() );
    }
    
    public function getErrors()
    {
        return $this->validator->errors()->getMessages();
    }

    public function getErrorsString(){
        $ret = null;
        
        foreach( $this->validator->errors()->getMessages() as $messagI => $messagV ){
            
             $ret.= $messagI.':'.$messagV[0].PHP_EOL;

        }
        
        return $ret;
    }

   
}
