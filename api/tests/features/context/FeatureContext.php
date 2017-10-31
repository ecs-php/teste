<?php

namespace Tests\Acceptance;

use Behat\Behat\Context\Context;
use Domain\Draw;
use Domain\Winner;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $winner;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->dbConnection();
    }

    private function dbConnection()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '10.0.75.1',
            'database'  => 'default',
            'username'  => 'default',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * @Given /^i post metadata (.*), (.*), (.*), (.*), (.*), (.*)$/
     */
    public function iPostMetadata($first_name, $last_name, $birthday, $identity, $city, $state)
    {
        $winner = new \Domain\Winner();
        $winner->first_name = $first_name;
        $winner->last_name = $last_name;
        $winner->birthday = $birthday;
        $winner->identity = $identity;
        $winner->city = $city;
        $winner->state = $state;
        $winner->save();
        $this->winner = $winner;
    }

    /**
     * @Then /^I shoud get a winner from database$/
     */
    public function iShoudGetAWinnerFromDatabase()
    {
        return $this->winner;
    }

    /**
     * @Given /^A winner id (.*)$/
     */
    public function aWinnerId($id)
    {
        return $this->winner = Winner::find($id);
    }

    /**
     * @Then /^I should get a winner from database$/
     */
    public function iShouldGetAWinnerFromDatabase()
    {
        return $this->winner;
    }

    /**
     * @Then /^I should delete them from database$/
     */
    public function iShouldDeleteThemFromDatabase()
    {
        $winner = new \Domain\Winner();
        $winner->first_name = 'Test';
        $winner->last_name = 'Test';
        $winner->birthday = '2017-01-01';
        $winner->identity = '48641943';
        $winner->city = 'Sao Paulo';
        $winner->state = 'SP';
        $winner->save();

        return $winner->delete();
    }

    /**
     * @Then /^I shoud update a winner  from database$/
     */
    public function iShoudUpdateAWinnerFromDatabase()
    {
        $winner = new \Domain\Winner(['id' => 1]);
        $winner->first_name = 'Test Update';
        $winner->last_name = 'Test';
        $winner->birthday = '2017-01-01';
        $winner->identity = rand(100000000, 900000000);
        $winner->city = 'Sao Paulo';
        $winner->state = 'SP';
        $winner->save();
    }

    /**
     * @Given /^A get request$/
     */
    public function aGetRequest()
    {
    }

    /**
     * @Then /^I should see a list of draws from database$/
     */
    public function iShouldSeeAListOfDrawsFromDatabase()
    {
        return Winner::all();
    }

    /**
     * @Given /^i put metadata (.*), (.*), (.*), (.*), (.*), (.*), (.*)$/
     */
    public function iPutMetadata($id, $first_name, $last_name, $birthday, $identity, $city, $state)
    {
        $winner = new \Domain\Winner(['id' => $id]);
        $winner->first_name = $first_name;
        $winner->last_name = $last_name;
        $winner->birthday = $birthday;
        $winner->identity = $identity;
        $winner->city = $city;
        $winner->state = $state;
        $winner->save();
    }

    /**
     * @Given /^post metadata (.*), (.*)$/
     */
    public function postMetadata($date, $winner_id = null)
    {
        $drawn = new Draw();
        $drawn->date = $date;
        if ($winner_id) {
            $drawn->winner_id = $date;
        }
        $drawn->save();
    }
}
