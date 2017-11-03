<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

// Routes


$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->get('/auth', function (Request $request, Response $response) use ($app) {
    $key = $this->get("secretkey");
    $token = array(
        "id" => "54564445",
        "user" => "root",
    );
    $jwt = JWT::encode($token, $key);
    return $response->withJson(["auth-jwt" => $jwt], 200)
        ->withHeader('Content-type', 'application/json');
});





$app->get('/user', function ($request, $response, $args) {
    if($request->getContentType() == 'application/json'){
        $id = $args['id'];
        $sth = $this->db->prepare("SELECT id, name, email, phone FROM users ORDER BY name");
        $sth->execute();
        $result = $sth->fetchAll();
        return $this->response->withJson(['msg' => "Success when list user: {$id}", 'data' => $result], 200)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});



// Retrieve todo with id
$app->get('/user/[{id}]', function ($request, $response, $args) {
    if($request->getContentType() == 'application/json'){
        $id = $args['id'];
        $sth = $this->db->prepare("SELECT id, name, email, phone FROM users WHERE id=:id");
        $sth->bindParam("id", $id);
        $sth->execute();
        $result = $sth->fetchObject();
        return $this->response->withJson(['msg' => "Success when list all users", 'data' => $result], 200)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});

// Add a new todo
$app->post('/user', function ($request, $response) {
    if($request->getContentType() == 'application/json'){
        $input = $request->getParsedBody();
        $password = crypt($input['password']);
        $code = rand(000000000000, 999999999999)."-".rand(0, 9);
        $sql = "INSERT INTO users (name, email, phone, city, code, password)  VALUES (:name, :email, :phone, :city, :code :password)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name",         $input['name']);
        $sth->bindParam("email",        $input['email']);
        $sth->bindParam("phone",        $input['phone']);
        $sth->bindParam("city",         $input['city']);
        $sth->bindParam("code",         $code);
        $sth->bindParam("password",     $password);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson(['msg' => "Success when register user", 'data' => $input], 201)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});


// Update todo with given id
$app->put('/user/[{id}]', function ($request, $response, $args) {
    if($request->getContentType() == 'application/json'){
        $id = $args['id'];
        $input = $request->getParsedBody();
        $password = crypt($input['password']);
        $sql = "UPDATE users SET name=:name, email=:email, phone=:phone, password=:password WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id",           $id);
        $sth->bindParam("name",         $input['name']);
        $sth->bindParam("email",        $input['email']);
        $sth->bindParam("phone",        $input['phone']);
        $sth->bindParam("password",     $password);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson(['msg' => "Success when update user: {$id}", 'data' => $input], 200)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});


// DELETE a todo with given id
$app->delete('/user/[{id}]', function ($request, $response, $args) {
    if($request->getContentType() == 'application/json'){
        $id = $args['id'];
        $sth = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $sth->bindParam("id", $id);
        $sth->execute();
        return $this->response->withJson(['msg' => "Success when deleting user: {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});


$app->get('/draw-date', function ($request, $response) {
    if($request->getContentType() == 'application/json'){
        $sth = $this->db->prepare("SELECT DATE_FORMAT(date, '%d/%m') as date FROM draw_dates ORDER BY date");
        $sth->execute();
        $result = $sth->fetchAll();
        return $this->response->withJson(['msg' => "Success when list draw dates", 'data' => $result], 200)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }

});

$app->get('/winner', function ($request, $response) {
    if($request->getContentType() == 'application/json'){
        $sth = $this->db->prepare("SELECT code, DATE_FORMAT(date, '%d/%m') as date , city FROM winners INNER JOIN users ON users.id = winners.user_id INNER  JOIN draw_dates ON draw_dates.id = winners.`draw_date_id`  ORDER BY name");
        $sth->execute();
        $result = $sth->fetchAll();
        return $this->response->withJson(['msg' => "Success when list winners", 'data' => $result], 200)
            ->withHeader('Content-type', 'application/json');
    } else {
        throw new \InvalidArgumentException("Content-type invalid", 400);
    }
});
