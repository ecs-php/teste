<?php
/**
 * Created by PhpStorm.
 * User: ercy
 * Date: 23/02/17
 * Time: 18:02
 */

namespace TESTE\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use TESTE\Model\User as UserModel;
use TESTE\Entity\User as UserEntitty;
use \Exception;


class User
{
    function __construct(Application $app) {
        $this->app = $app;
        $this->personModel = new UserModel($app);
    }

    public function singupAction(Request $request)
    {
        $person = new UserEntitty();

        $person->setUserName($request->request->get('username'));
        $person->setEmail($request->request->get('email'));


        $person = $this->personModel->insert($person);

        return $person->toArray();
    }

    public function authenticate(Request $request)
    {
        $userModel = new UserModel($this->app);
        $userModel->authentication($request->request->get('username'),$request->request->get('token'));
    }
}