<?php
  ### timezone
  date_default_timezone_set("America/Sao_Paulo");

  require_once __DIR__ . '\vendor\autoload.php';

  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;

  $app = new Silex\Application();

  ### Dados e acesso ao BD
  $dbname = "test";
  $host   = "127.0.0.1";
  $user   = "root";
  $pass   = "";

  ### Conectando ao BD
  $dsn = "mysql:dbname=$dbname;host=$host;charset=utf8";
  try {
    $dbh = new PDO($dsn, $user, $pass);
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }

  ### listar clientes
  $app->get('/customers', function () use ($app, $dbh) {
    // consulta todos clientes
    $sth = $dbh->prepare('SELECT name, cpf, birth_date, email FROM tb_customers');
    $sth->execute();
    $customers = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $app->json($customers);
  });

  ### listar cliente conforme id
  $app->get('/customers/{id}', function ($id) use ($app, $dbh) {
    // consulta todos clientes
    $sth = $dbh->prepare('SELECT name, cpf, birth_date, email FROM tb_customers WHERE id_customer = ?');
    $sth->execute([ $id ]);
    $customers = $sth->fetchAll(PDO::FETCH_ASSOC);

    echo __LINE__ . "<br />";

    return $app->json($customers);
  });

  ### incluir cliente
  $app->post('/customers', function(Request $request) use ($app, $dbh) {
    $dados = array(
      'name'        => $request->get('name'),
      'cpf'         => $request->get('cpf'),
      'birth_date'  => $request->get('birth_date'),
      'email'       => $request->get('email'),
    );
    
    $sth = $dbh->prepare("
      INSERT INTO tb_customers (name, cpf, birth_date, email)
      VALUES(:name, :cpf, :birth_date, :email)
    ");

    $sth->execute($dados);
    $id = $dbh->lastInsertId();

    ### response, 201 created
    $response = new Response('Ok', 201);
    $response->headers->set('Location', "/customers/$id");
    return $response;
  });
  
  // editar cliente
  $app->put('/customers/{id}', function(Request $request, $id) use ($app, $dbh) {
    $dados = array(
      'name'        => $request->get('name'),
      'cpf'         => $request->get('cpf'),
      'birth_date'  => $request->get('birth_date'),
      'email'       => $request->get('email'),
      'id'          => $id,
    );
    $sth = $dbh->prepare("
      UPDATE tb_customers 
      SET name = :name, cpf = :cpf, birth_date = :birth_date, email = :email
      WHERE id_customer = :id
    ");
     
    $sth->execute($dados);
    return $app->json($dados, 200);
  })->assert('id', '\d+');

  ### excluir cliente
  $app->delete('/customers/{id}', function($id) use ($app, $dbh) {
    $sth = $dbh->prepare('DELETE FROM tb_customers WHERE id_customer = ?');
    $sth->execute([ $id ]);

    if($sth->rowCount() < 1) {
      return new Response("Cliente com id {$id} não encontrado para exclusão!", 404);
    }

    ### registro foi excluido, retornar 204 - no content
    return new Response(null, 204);
  })->assert('id', '\d+');

  $app->run();