<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                                        'id' => '1',
                                        'name' => 'Admin Mini App',
                                        'email' => 'admin@company.com',
                                        'password' => 'testes',
                                        'api_token' => '8de70cb01900c98625fd6f484fc1468ba2fadb93',
                                        'created_at'=>'2017-05-02 21:45:23',
                                        'updated_at'=>'2017-05-02 21:45:23',
                                        ]);
       
        DB::table('employee')->insert([
                                        'id' => '1',
                                        'name' => 'employe number one',
                                        'email' => 'one@company.com',
                                        'address' => 'address =]',
                                        'number' => '10B',
                                        'phone' => '465465465464',
                                        'cpf' => '1144777744',
                                        'created_at'=>'2017-05-02 21:45:23',
                                        'updated_at'=>'2017-05-02 21:45:23',
                                        ]);



    }
}
