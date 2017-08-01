<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PeopleController
{

    /**
     * Method responsible to retrieve from the database the entire list of people registered.
     * It will return a json string with all the registers.
     * 
     * @param Application $app
     * @return json
     */
    public function index (Application $app)
    {
        $people = $app['db']->fetchAll('SELECT * FROM people');

        return $app->json($people);
    }

    /**
     * Returns a json string containing all the information about a person. Will receive as a 
     * parameter the id related to the register.
     *
     * @param integer $id
     * @param Application $app
     * @return void
     */
    public function get ($id, Application $app)
    {
        $person = $app['db']->fetchAssoc('SELECT * FROM people WHERE id = ?', [$id]);

        if($person)
            return $app->json($person);
        else
            return $app->json(['success' => false, 'message' => 'Could not found any user with this ID']);
    }

    /**
     * Method that will be responsible to insert a new register on the database.
     *
     * @param Request $request
     * @param Application $app
     * @return void
     */
    public function insert (Request $request, Application $app)
    {
        $newPerson = $request->request->all();
        $newPerson['created_at'] = date("Y-m-d H:i:s");

        $success = $app['db']->insert('people', $newPerson);

        if($success)
            return $app->json(['success' => true, 'message' => 'A new person has been created in the name of '.$newPerson['name']]);
        else
            return $app->json(['success' => false, 'message' => "Due an unexpected error it was unable to create the person's register."]);
    }

    /**
     * Method that will update the information about a register that will be passed by parameter on the
     * request header.
     *
     * @param Request $request
     * @param Application $app
     * @return void
     */
    public function update (Request $request, Application $app)
    {
        $person = $request->request->all();
        $newPerson['updated_at'] = date("Y-m-d H:i:s");

        $success = $app['db']->update('people', $person, ['id' => $person['id']]);

        if($success)
            return $app->json(['success' => true, 'message' => 'The data about '.$person['name'].' has been updated.']);
        else
            return $app->json(['success' => false, 'message' => "Due an unexpected error it was impossible to update the data about the related Person."]);
    }

    /**
     * Method responsible for delete a register from the database. Will receive as a 
     * parameter the id related to the register.
     *
     * @param integer $id
     * @param Application $app
     * @return void
     */
    public function delete ($id, Application $app)
    {
        $deleted = $app['db']->delete('people', ['id' => $id]);

        if($deleted)
            return $app->json(["success" => true, "message" => "The related register has been deleted from the database."]);
        else
            return $app->json(["success" => false, "message" => "We could not delete the register you looking for."]);
    }

}