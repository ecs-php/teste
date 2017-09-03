<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/09/17
 * Time: 22:39
 */

namespace Classes;

use Symfony\Component\HttpFoundation\Response;

class ProductRepository
{
    private $app;
    private $request;


    private static $authentication = null;

    /**
     * @return ProductRepository
     */
    public static function get()
    {
        if (self::$authentication == null) {
            self::$authentication = new ProductRepository();
        }
        return self::$authentication;
    }

    public function init($request, $app)
    {
        $this->request = $request;
        $this->app = $app;
    }


    public function listAll()
    {
        $sql = "SELECT * FROM `tb_product` WHERE user_id = ? ";
        $post = $this->app['db']->fetchAll($sql, array(
            $this->request->attributes->get("id_user")
        ));

        return $post;
    }


    public function getOne($product_id)
    {
        $sql = "SELECT * FROM `tb_product` WHERE user_id = ? AND id = ? ";
        $post = $this->app['db']->fetchAssoc($sql, array(
            $this->request->attributes->get("id_user"),
            $product_id
        ));

        return $post;
    }

    public function addOne($product)
    {
        $date = new \DateTime('now');
        $sql = "INSERT INTO `tb_product` (`user_id`, `title`, `cantidade`, `description`, `created_at`) VALUES (?, ?, ?, ?, ?);";
        $post = $this->app['db']->executeUpdate($sql, array(
            (int)$this->request->attributes->get("id_user"),
            $product['title'],
            (int)$product['cantidade'],
            $product['description'],
            $date->format('Y-m-d H:i:s')
        ));

        $sql = "SELECT * FROM `tb_product` WHERE user_id = ? ORDER BY created_at DESC";
        $post = $this->app['db']->fetchAssoc($sql, array(
            $this->request->attributes->get("id_user")
        ));

        return $post;
    }

    public function updateOne($product_id, $product)
    {
        $string_keys = "";
        $parameters_value = array();
        foreach ($product as $key => $value) {
            if($string_keys!="") $string_keys.=" , ";
            $string_keys .= " `" . $key . "` = ? ";
            $parameters_value[] = $value;
        }


        if (count($parameters_value) > 0) {
            $parameters_value[] = (int)$product_id;
            $parameters_value[] = $this->request->attributes->get("id_user");
            $sql = "UPDATE tb_product SET ".$string_keys." WHERE id = ? AND user_id = ?";
            $post = $this->app['db']->executeUpdate($sql, $parameters_value);
        }
        $sql = "SELECT * FROM `tb_product` WHERE id = ? AND user_id = ?";
        $post = $this->app['db']->fetchAssoc($sql, array(
            (int)$product_id,
            $this->request->attributes->get("id_user"),
        ));

        return $post;
    }

    public function removeOne($product_id)
    {

        $sql = "SELECT * FROM `tb_product` WHERE id = ? AND user_id = ?";
        $post = $this->app['db']->fetchAssoc($sql, array(
            (int)$product_id,
            $this->request->attributes->get("id_user"),
        ));

        if(!$post){
            return new Response('', 400);
        }
        $sql = "DELETE FROM `tb_product` WHERE id = ? AND user_id = ?";
        $post = $this->app['db']->executeUpdate($sql, array(
            (int)$product_id,
            $this->request->attributes->get("id_user"),
        ));

        return new Response('', 204);
    }

}