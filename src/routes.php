<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/participantes', function ($request, $response, $args) {
    if($request->getContentType() == 'application/json'){
        $sth = $this->db->prepare("SELECT id, name, email, phone FROM users ORDER BY name");
        $sth->execute();
        $result = $sth->fetchAll();
        return $this->response->withJson($result);
    } else {

    }

});



// Retrieve todo with id
$app->get('/participantes/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT id, name, email, phone FROM users WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});

// Add a new todo
$app->post('/participantes', function ($request, $response) {
    $request->headers->get('Content-Type');
    $input = $request->getParsedBody();
    $password = crypt($input['password']);
    $sql = "INSERT INTO users (name, email, phone, password)  VALUES (:name, :email, :phone, :password)";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("name",         $input['name']);
    $sth->bindParam("email",        $input['email']);
    $sth->bindParam("phone",        $input['phone']);
    $sth->bindParam("password",     $password);
    $sth->execute();
    $input['id'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
});


// Update todo with given id
$app->put('/participantes/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $password = crypt($input['password']);
    $sql = "UPDATE users SET name=:name, email=:email, phone=:phone, password=:password WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id",           $args['id']);
    $sth->bindParam("name",         $input['name']);
    $sth->bindParam("email",        $input['email']);
    $sth->bindParam("phone",        $input['phone']);
    $sth->bindParam("password",     $password);
    $sth->execute();
    $input['id'] = $args['id'];
    return $this->response->withJson($input);
});


// DELETE a todo with given id
$app->delete('/participantes/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM users WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    return $this->response->withJson('Success when deleting user!');
});