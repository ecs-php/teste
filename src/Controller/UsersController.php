<?php

namespace Controller;

use Entity\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class UsersController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];
        $indexController->get("/", array($this, 'index'))->bind('users_index');
        $indexController->post("/save", array($this, 'create'))->bind('users_create');
        $indexController->put("/save/{id}", array($this, 'update'))->bind('users_update');
        $indexController->get("/userloggedin", array($this, 'userLoggedIn'))->bind('users_userLoggedIn');
        $indexController->post("/login", array($this, 'login'))->bind('users_login');
        $indexController->get("/logout", array($this, 'logout'))->bind('users_logout');

        $indexController->get("/{id}", array($this, 'show'))->bind('users_show');
        $indexController->delete("/{id}", array($this, 'delete'))->bind('users_delete');

        return $indexController;
    }

    public function index(Application $app)
    {
        $em = $app['db.orm.em'];
        $users = $em->getRepository('Entity\User')->findAll();
        $data = array();
        foreach ($users as $user)
        {
            /** @var $user User */
            $data[] = $user->serialize();
        }

        return $app->json($data, 200);
    }

    public function show(Application $app, $id)
    {
        $em = $app['db.orm.em'];
        /** @var $user User */
        $user = $em->getRepository('Entity\User')->find($id);
        if (!$user) {
            $app->abort(404, 'No user found for id ' . $id);
        }
        return $app->json($user->serialize(), 200);
    }

    public function create(Application $app, Request $request) {

        $em = $app['db.orm.em'];
        $data = json_decode($request->getContent());
        /** @var $user User */
        $user = new User();
        $user->setAll($data);
        $em->persist($user);
        $em->flush();
        return $app->json($user->getId(), 200);
    }

    public function update(Application $app, Request $request, $id) {

        $data = json_decode($request->getContent(), true);;
        $em = $app['db.orm.em'];
        /** @var $user User */
        $user = $em->getRepository('Entity\User')->find($id);
        $user->setAll($data);
        $em->persist($user);
        $em->flush();
        return $app->json(array(
            'user_id' => $user->getId(),
            'data' => $user->serialize(),
        ), 200);
    }

    public function delete(Application $app, $id) {

        $em = $app['db.orm.em'];
        /** @var $user User */
        $user = $em->getRepository('Entity\User')->find($id);

        if (!$user) {
            return $app->json(array(
                'user_id' => $id,
                'success' => false,
                'error'   => 'No user found for id ' . $id
            ), 200);
        }

        $em->remove($user);
        $em->flush();

        return $app->json(array(
            'user_id' => $id,
            'success' => true
        ), 200);
    }

    public function userLoggedIn(Application $app)
    {
        return $app->json(array(
            'user' => $app['session']->get('user')
        ), 200);
    }

    public function login(Application $app, Request $request)
    {
        $em = $app['db.orm.em'];
        $data = json_decode($request->getContent());
        /** @var $user User */
        $user = $em->getRepository('Entity\User')->findOneBy(array(
            'username' => $data->username,
            'isActive' => true
        ));
        if ($user) {
            if($user->password_verify($data->password, $user->getPassword())) {
                $app['session']->set('user', array($user->serialize()));
                return $app->json(array(
                    'user' => $app['session']->get('user'),
                    'success' => true
                ), 200);
            } else {
                return $app->json(array(
                    'user' => 'none',
                    'username' => $data->username,
                    'password' => $data->password,
                    'error' => 'Incorrect password'
                ), 200);
            }
        } else {
            return $app->json(array(
                'user' => 'none',
                'username' => $data->username,
                'password' => $data->password,
                'error' => 'User not found'
            ), 200);
        }
    }

    public function logout(Application $app){
        $app['session']->remove('user');
        return $app->json(true, 200);
    }

}