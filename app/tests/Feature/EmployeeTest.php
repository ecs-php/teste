<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use app\Service\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Database\Seeder;
use app\Requests\EmployeeRequests;

class EmployeeTest extends TestCase
{

   use DatabaseMigrations;
    
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

     public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
    
    public function testListOneItemSeeder()
    {

         $emp = new EmployeeService();
         $lista = $emp->listAll( );
        
         $this->assertEquals( 1 ,count($lista) );
      
         $this->assertTrue( isset($lista['employees'][0]['name']) );
    
    }
    
    public function testGetEmployee()
    {

         $emp = new EmployeeService();
         $lista = $emp->getItem( '1' );
         
         $esperado = '{"employee":{"id":1,"name":"employe number one","email":"one@company.com","address":"address =]","number":"10B","phone":"465465465464","cpf":"1144777744","created_at":"2017-05-02 21:45:23","updated_at":"2017-05-02 21:45:23"}}';
         $this->assertEquals( $esperado , json_encode($lista) );
    
    }
    
    public function testRemoveEmployee()
    {

         $emp = new EmployeeService();
         $lista = $emp->remove( '1' );
         
         $lista = $emp->getItem( '1' );
         
         $esperado = '[]';
         $this->assertEquals( $esperado , json_encode($lista) );
    
    }

    public function testCreateEmployee()
    {   
        
        $emp = new EmployeeService();
       
        $criado = $emp->create(
                        new EmployeeRequests(
                                        [
                                            'name' => 'employe number two',
                                            'email' => 'two@company.com',
                                            'address' => 'address =]',
                                            'number' => '10B',
                                            'phone' => '465465465464',
                                            'cpf' => '1144777744',
                                            'created_at' => date('Y-m-d H:i:s')
                                        ]
                                    )
                        );
       
        $now = date('Y-m-d H:i:s');
        $aguardado = '{"employee":[{"name":"employe number two","email":"two@company.com","address":"address =]","number":"10B","phone":"465465465464","cpf":"1144777744","updated_at":\"'.$now.'\","created_at":\"'.$now.'\","id":2}]}';
       
        $this->assertEquals(str_replace("\\","",$aguardado), json_encode( $criado ) );
    
    }

    public function testUpdateEmployee()
    {   
        
        $emp = new EmployeeService();
       
        $criado = $emp->update(
                        new EmployeeRequests(
                                        [
                                            'id' => '1',
                                            'name' => 'employe number one updated',
                                            'email' => 'one-updated@company.com',
                                            'address' => 'address =]',
                                            'number' => '10B',
                                            'phone' => '465465465464',
                                            'cpf' => '1144777744',
                                        ]
                                    )
                        );
       
        $now = date('Y-m-d H:i:s');
       
        $aguardado = '{"employee":[{"id":1,"name":"employe number one updated","email":"one-updated@company.com","address":"address =]","number":"10B","phone":"465465465464","cpf":"1144777744","created_at":\"'.$criado['employee'][0]['created_at'].'\","updated_at":\"'.$now.'\"}]}';
       
        $this->assertEquals(str_replace("\\","",$aguardado), json_encode( $criado ) );
    
    }

   /**
     * @expectedException     app\Exceptions\EmployeeRequestException
     */
    public function testCreateFailRulesPhoneCpfNumericEmployee()
    {   
        
        $emp = new EmployeeService();
       
        $criado = $emp->create(
                        new EmployeeRequests(
                                        [
                                            'name' => 'employe number two',
                                            'email' => 'two@company.com',
                                            'address' => 'address =]',
                                            'number' => '10B',
                                            'phone' => '465465465AA',
                                            'cpf' => '11447777AA',
                                        ]
                                    )
                        );
     
    }

   /**
     * @expectedException     app\Exceptions\EmployeeRequestException
     */
    public function testUpdateFailRulesPhoneCpfNumericEmployee()
    {   
        
        $emp = new EmployeeService();
       
        $criado = $emp->update(
                        new EmployeeRequests(
                                        [
                                            'name' => 'employe number two',
                                            'email' => 'two@company.com',
                                            'address' => 'address =]',
                                            'number' => '10B',
                                            'phone' => '465465465AA',
                                            'cpf' => '11447777AA',
                                        ]
                                    )
                        );
     
    }


}

