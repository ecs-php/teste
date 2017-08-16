<?php
 
namespace Serasa\Controller;
 
use DateTime;
use Exception;
use JMS\Serializer\SerializerBuilder;
use Serasa\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    } 

    public function list(Application $app, Request $request) 
    {
        $em  = $app['orm.em'];
        $users = $em->getRepository('Serasa\Model\User')->findAll();

        return $this->serializer->serialize($users, 'json');
    }

    public function find(Application $app, Request $request, $id) 
    {   
        $em  = $app['orm.em'];
        $user = $em->getRepository('Serasa\Model\User')->find($id);

        if ( !$user ) {
            throw new Exception("User not found", 404);
        }
        
        return $this->serializer->serialize($user, 'json');
    }

    public function create(Application $app, Request $request) 
    {
        $user = new User();
        $em  = $app['orm.em'];
        $data = $request->request->all();

        $em->persist($this->setData($user, $data));
        $em->flush();

        return new Response($this->serializer->serialize($user, 'json'), 201);
    }

    public function update(Application $app, Request $request, $id) 
    {
        $em  = $app['orm.em'];
        $data = $request->request->all();
        $user = $em->getRepository('Serasa\Model\User')->find($id);
        if ( !$user ) {
            throw new NotFoundException("User not found", 404);
        }

        $em->persist($this->setData($user, $data));
        $em->flush();

        return new Response($this->serializer->serialize($user, 'json'), 200);
    }

    public function delete(Application $app, Request $request, $id) 
    {
        $em  = $app['orm.em'];
        $user = $em->getRepository('Serasa\Model\User')->find($id);

        if ( !$user ) {
            throw new NotFoundException("User not found", 404);
        }
        
        try 
        {
            $em->remove($user);
            $em->flush();
        } 
        catch (Exception $e) 
        {
            throw new Exception("Couldn't remove user", 400);
        }
        
        return $app->json('',204);
    }

    private function setData(User $user, $data)
    {
        if(
            !array_key_exists('name', $data) || 
            !array_key_exists('email', $data) ||
            !array_key_exists('age', $data) ||
            !array_key_exists('address', $data)
        ) {
            throw new Exception("All fields are mandatory", 400);
        }

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setAge($data['age']);
        $user->setAddress($data['address']);

        if($user->getCreated() && !$user->getUpdated()) {
            $user->setUpdated(new DateTime());
        }

        return $user;
    }
} 