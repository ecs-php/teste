<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Database\Seeder;


class ApiTest extends TestCase
{
    public function setUp(){
        
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->token = '8de70cb01900c98625fd6f484fc1468ba2fadb93';
    }

     public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

       public function testListEmployee()
        {   
           $return = $this->post('/api/v1/employees',['api_token' => $this->token])
                ->assertStatus(200)
                    ->assertJson([
                            'employees' => 
                                                ['0' => 
                                                        [
                                                            'id' => '1',
                                                            'name' => 'employe number one',
                                                            'email' => 'one@company.com',
                                                            'address' => 'address =]',
                                                            'number' => '10B',
                                                            'phone' => '465465465464',
                                                            'cpf' => '1144777744',
                                                            'created_at'=>'2017-05-02 21:45:23',
                                                            'updated_at'=>'2017-05-02 21:45:23',
                                                        ]
                                            ] 
                         ]);

        }

       public function testGetItem()
        {   
           $id = 1;
           $this->post('/api/v1/employee/'.$id,['api_token' => $this->token])
                ->assertStatus(200)
                    ->assertJson([
                            'employee' => 
                                            [
                                                'id' => '1',
                                                'name' => 'employe number one',
                                                'email' => 'one@company.com',
                                                'address' => 'address =]',
                                                'number' => '10B',
                                                'phone' => '465465465464',
                                                'cpf' => '1144777744',
                                                'created_at'=>'2017-05-02 21:45:23',
                                                'updated_at'=>'2017-05-02 21:45:23',
                                                
                                            ]
                                            
                         ]);

        }

       public function testCreateItem()
        {   
          $var = $this->post('/api/v1/employee/create',[
                                                        'name' => 'employe number two',
                                                        'email' => 'two@company.com',
                                                        'address' => 'address =]',
                                                        'number' => '10B',
                                                        'phone' => '465465465464',
                                                        'cpf' => '1144777744',
                                                        'api_token' => $this->token
                                                    ])
                ->assertStatus(200)
                    ->assertJson([
                           "employee" => [
                                        '0'=>[
                                                "name" => "employe number two",
                                                "email" =>"two@company.com",
                                                "address" => "address =]",
                                                "number" => "10B",
                                                "phone" => "465465465464",
                                                "cpf" => "1144777744",
                                                "updated_at" => date('Y-m-d H:i:s'),
                                                "created_at" => date('Y-m-d H:i:s'),
                                                "id"=> "2"
                                            ]
                                    
                                    ]

         
                         ]);

        }

       public function testUpdateItem()
        {   
           $id = 1;
           $return = $this->post('/api/v1/employee/update/'.$id , [
                                                        'id' => '1',
                                                        'name' => 'employe number two',
                                                        'email' => 'two@company.com',
                                                        'address' => 'address =]',
                                                        'number' => '10B',
                                                        'phone' => '465465465464',
                                                        'cpf' => '1144777744',
                                                        'api_token' => $this->token
                                                    ])
                ->assertStatus(200)
                    ->assertJson([
                            "employee" => [
                                        '0'=>[
                                                "id" => "1",
                                                "name" => "employe number two",
                                                "email" =>"two@company.com",
                                                "address" => "address =]",
                                                "number" => "10B",
                                                "phone" => "465465465464",
                                                "cpf" => "1144777744",
                                                "created_at" => '2017-05-02 21:45:23',
                                                "updated_at" => date('Y-m-d H:i:s'),
                                            ]
                                    ]
         
                         ]);

        }

        public function testRemoveItem()
        {   
           $id = 1;
           $this->post('/api/v1/employee/remove/'.$id,['api_token' => $this->token])
                ->assertStatus(200)
                    ->assertJson([]);

        }

        public function testUpdateFailItem()
        {   
           $id = 1;
           $return = $this->post('/api/v1/employee/update/'.$id , [
                                                        'id' => '1',
                                                        'name' => 'employe number two',
                                                        'email' => 'two@company.com',
                                                        'address' => 'address =]',
                                                        'number' => '10B',
                                                        'phone' => '465465465464ASS',
                                                        'cpf' => '1144777744SSSS',
                                                        'api_token' => $this->token
                                                    ])
                ->assertStatus(200)
                    ->assertJson([
                           
                                "phone:The phone must be a number.\ncpf:The cpf must be a number.\n"
                                ]);

        }

        public function testCreateFailItem()
        {   
          $var = $this->post('/api/v1/employee/create',[
                                                        'name' => 'employe number two',
                                                        'email' => 'two@company.com',
                                                        'address' => 'address =]',
                                                        'number' => '10B',
                                                        'phone' => '465465465464',
                                                        'cpf' => '1144777744AA',
                                                        'api_token' => $this->token
                                                    ])
                ->assertStatus(200)
                    ->assertJson([
                                "cpf:The cpf must be a number.\n"         
                                ]);

        }

        


}
