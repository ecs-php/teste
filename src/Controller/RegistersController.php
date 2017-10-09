<?php

namespace Controller;

use Entity\Register;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistersController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];
        $indexController->get("/", array($this, 'index'))->bind('cadastro_index');
        $indexController->post("/save", array($this, 'create'))->bind('cadastro_create');
        $indexController->put("/save/{id}", array($this, 'update'))->bind('cadastro_update');
        $indexController->get("/{id}", array($this, 'show'))->bind('cadastro_show');
        $indexController->delete("/{id}", array($this, 'delete'))->bind('cadastro_delete');

        return $indexController;
    }

    public function index(Application $app)
    {
        $em = $app['db.orm.em'];
        $registers = $em->getRepository('Entity\Register')->findAll();
        $data = array();
        foreach ($registers as $register) {
            /** @var $user User */
            $data[] = $register->serialize();
        }

        return $app->json($data, 200);
    }

    public function show(Application $app, $id)
    {
        $em = $app['db.orm.em'];
        /** @var $register Register */
        $register = $em->getRepository('Entity\Register')->find($id);
        if (!$register) {
            $app->abort(404, 'No register found for id ' . $id);
        }
        return $app->json($register->serialize(), 200);
    }

    public function create(Application $app, Request $request)
    {

        $em = $app['db.orm.em'];
        $data = json_decode($request->getContent());
        /** @var $user User */
        $register = new Register();
        $user->setAll($data);
        $em->persist($register);
        $em->flush();
        return $app->json($register->getId(), 200);
    }

    public function update(Application $app, Request $request, $id)
    {

        $data = json_decode($request->getContent(), true);;
        $em = $app['db.orm.em'];
        /** @var $register Register */
        $register = $em->getRepository('Entity\Register')->find($id);
        $register->setAll($data);
        $em->persist($register);
        $em->flush();
        return $app->json(array(
            'user_id' => $register->getId(),
            'data' => $register->serialize(),
        ), 200);
    }

    public function delete(Application $app, $id)
    {

        $em = $app['db.orm.em'];
        /** @var $register Register */
        $register = $em->getRepository('Entity\Register')->find($id);

        if (!$register) {
            return $app->json(array(
                'user_id' => $id,
                'success' => false,
                'error' => 'No register found for id ' . $id
            ), 200);
        }

        $em->remove($register);
        $em->flush();

        return $app->json(array(
            'user_id' => $id,
            'success' => true
        ), 200);
    }

}