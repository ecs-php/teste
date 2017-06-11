<?php
/**
 * Created by PhpStorm.
 * User: ercy
 * Date: 23/02/17
 * Time: 18:02
 */

namespace TESTE\Model;

use TESTE\Entity\User as UserEntity;
use \Exception;

class User
{
    protected $app;

    function __construct($app) {
        $this->app = $app;
    }

    public function getAll()
    {
        $repository = $this->app['orm.em']->getRepository('TESTE\Entity\User');
        $list = $repository->findAll();

        $response = [];
        foreach ($list as $user){
            $response[] =  $user->toArray();
        }

        return $response;
    }

    public function insert(UserEntity $user)
    {
        return $this->save($user);
    }

    public function update(UserEntity $user)
    {
        return $this->save($user);
    }

    protected function save(UserEntity $user)
    {
        $this->app['orm.em']->persist($user);
        $this->app['orm.em']->flush();

        return $user;
    }

    public function delete(UserEntity $user)
    {
        if ( $user == NULL){
            throw new Exception("No data found!");
        }
        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();

        return $user;
    }

    public function authentication($username, $token)
    {
        $repository = $this->app['orm.em']->getRepository('TESTE\Entity\User');
        /**
         * @var UserEntity
         */
        $user = $repository->findOneBy(array('username' =>  $username ) );

        if ( $token != $user->getToken()){
            throw new Exception("Invalid Token");
        }
    }
}