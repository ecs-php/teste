<?php
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$dsn = 'mysql:dbname=test_thideoli;host=localhost;charset=utf8';
try {
    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    echo 'Falha ao conectar: ' . $e->getMessage();
}

$app->before(function(Request $request) use ($app) {
    if($request->isMethod('GET'))
        return;
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    } else {
        return $app->json(array('error' => true, 'message' => 'Cabeçalho somente com Content-Type: application/json'), 404);
    }
});

$app->before(function(Request $request) use ($app) {
    echo $request->getPathInfo();
    if($request->getPathInfo() == '/login')
        return;
    $token = $request->headers->get('x-access-token');
    if(!$token)
        return $app->json(array('error' => true, 'message' => 'Não a token'), 403);
    if(md5('admin123') != $token)
        return $app->json(array('error' => true, 'message' => 'Token inválido'), 403);
});

// POST /login
$app->post('/login', function(Request $request) use ($app) {
    if($request->get('user') == 'admin' && $request->get('password') == '123')
        return $app->json(array('error' => false, 'message' => null, 'content' => array('token' => md5('admin123'))));
    else
        return $app->json(array('error' => true, 'message' => 'Dado(s) incorreto(s).', 'content' => null), 401);
});

// GET /livros
$app->get('/livros', function () use ($app, $pdo) {
    $statement = $pdo->prepare('select id, title, author, publishing_company, pages, inserted_in, changed_in from books');
    $statement->execute();
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $app->json(array('error' => false, 'message' => null, 'content' => array('books' => $books)));
});

// GET /livro/{id}
$app->get('/livro/{id}', function ($id) use ($app, $pdo) {
    $statement = $pdo->prepare('select id, title, author, publishing_company, pages, inserted_in, changed_in from books where id=?');
    $statement->execute([$id]);
    $book = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(empty($book))
        return $app->json(array('error' => true, 'message' => 'Livro não encontrado.', 'content' => null), 404);
    return $app->json(array('error' => false, 'message' => null, 'content' => array('book' => $book)));
})->assert('id', '\d+');

// POST /livro
$app->post('/livro', function(Request $request) use ($app, $pdo) {
    $data = json_decode($request->getContent(), true);
    $statement = $pdo->prepare('insert into books (title, author, publishing_company, pages, inserted_in) VALUES(:title, :author, :publishing_company, :pages, now())');
    $statement->execute($data);
    $id = $pdo->lastInsertId();
    if($id > 0)
        return $app->json(array('error' => false, 'message' => 'Livro inserido', 'content' => array('id' => $id)), 201);
    return $app->json(array('error' => true, 'message' => 'Livro não inserido', 'content' => null), 404);
});

// PUT /livro/{id}
$app->put('/livro/{id}', function(Request $request, $id) use ($app, $pdo) {
    $data = json_decode($request->getContent(), true);
    $data['id'] = $id;
    $statement = $pdo->prepare('update books set title=:title, author=:author, publishing_company=:publishing_company, pages=:pages, changed_in=now() where id=:id');
    $statement->execute($data);
    if($statement->rowCount() < 1)
        return $app->json(array('error' => true, 'message' => 'Livro não encontrado', 'content' => null), 404);
    return $app->json(array('error' => false, 'message' => 'Livro alterado', 'content' => array('book' => $data)));
})->assert('id', '\d+');

// DELETE /livro/{id}
$app->delete('/livro/{id}', function($id) use ($app, $pdo) {
    $statement = $pdo->prepare('delete from books where id = ?');
    $statement->execute([$id]);
    if($statement->rowCount() < 1)
        return $app->json(array('error' => true, 'message' => 'Livro não encontrado', 'content' => null), 404);
    return $app->json(array('error' => false, 'message' => 'Livro deletado', 'content' => null));
})->assert('id', '\d+');

$app->run();