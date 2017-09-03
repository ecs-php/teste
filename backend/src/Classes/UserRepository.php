<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/09/17
 * Time: 22:39
 */

namespace Classes;

class UserRepository
{
    private $app;
    private $request;


    private static $authentication = null;

    /**
     * @return UserRepository
     */
    public static function get()
    {
        if (self::$authentication == null) {
            self::$authentication = new UserRepository();
        }
        return self::$authentication;
    }

    public function init($request, $app)
    {
        $this->request = $request;
        $this->app = $app;
    }

    public function getByAPIKey($apikey)
    {
        $sql = "SELECT * FROM `tb_user` WHERE apikey = ?";
        $post = $this->app['db']->fetchAssoc($sql, array($apikey));

        return $post;
    }

    public function getByEmailPassword($email, $password)
    {
        $sql = "SELECT * FROM `tb_user` WHERE email = ? AND password = ?";
        $post = $this->app['db']->fetchAssoc($sql, array($email, $password));

        return $post;
    }

    public function updateLastConnetion($id_usuario)
    {
        $date = new \DateTime('now');
        $sql = "UPDATE tb_user SET last_connection = ? WHERE id = ?";
        $post = $this->app['db']->executeUpdate($sql, array(
            $date->format('Y-m-d H:i:s'),
            (int) $id_usuario
        ));

        return $post;
    }
    public function updateApiKey($apikey, $id_usuario)
    {
        $sql = "UPDATE tb_user SET apikey = ? WHERE id = ?";
        $post = $this->app['db']->executeUpdate($sql, array(
            $apikey,
            (int) $id_usuario
        ));

        return $post;
    }
}