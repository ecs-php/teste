<?php

namespace BookStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BookStore\Services\Authentication;

class ApiController {

    function update(Application $app, Request $req, $id) {
        $fields = $req->request->all();
        $fields['dt_update'] = date('Y-m-d H:i:s');

        $book = $app['model']->create('Book');

        $response['msg'] = 'Erro ao alterar o registro.';
        $status = 500;

        if ($book->exist($id) && $book->update($fields, $id)) {
            $response['msg'] = 'Registro alterado com sucesso.';
            $status = 201;
        }

        return $app->json($response, $status);
    }

    function insert(Application $app, Request $req) {
        $fields = $req->request->all();

        $book = $app['model']->create('Book');

        $response['msg'] = 'Erro ao cadastrar o registro.';
        $status = 500;

        if ($book->insert($fields)) {
            $response['msg'] = 'Registro cadastrado com sucesso';
            $status = 200;
        }

        return $app->json($response, $status);
    }

    function all(Application $app) {
        $book = $app['model']->create('Book');

        $response['msg'] = 'Erro ao procurar os registros';
        $status = 500;

        $books = $book->getAll();

        if ($books) {
            $response = $books;
            $status = 200;
        }
        return $app->json($response, $status);
    }

    function delete(Application $app, $id) {
        $book = $app['model']->create('Book');

        $response['msg'] = 'Erro ao remover o registro, id: ' . $id;
        $status = 500;

        if ($book->delete($id)) {

            $response['msg'] = "Registro ($id) removido com sucesso.";
            $status = 200;
        }

        return $app->json($response, $status);
    }

    function authentication(Request $req) {

        $auth = new Authentication();

        $login = $req->headers->get('login');
        $pass = $req->headers->get('pass');

        if (!$auth->signIn($login, $pass)) {
            return new Response('Não autorizado!', 401);
        }
    }

}
