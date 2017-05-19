<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(GamesTableSeeder::class);

        Model::reguard();
    }
}

/**
 * Populate table Games
 */
class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Game::create([
            'title' => 'Battlefield Bad Company 2',
            'description' => str_random(100),
            'release_date' => date('Y-m-d'),
            'price' => 49.90
        ]);
        
        App\Game::create([
            'title' => 'Call of Duty WWII',
            'description' => str_random(100),
            'release_date' => date('Y-m-d'),
            'price' => 19.90
        ]);
    }
}

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'=>'APIUser', 
            'email'=>'thiagohenrique@protonmail.com', 
            'password'=>bcrypt('123456')
        ]);
    }
}