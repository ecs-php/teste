<?php 

// Set timezone
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

// Connect to MySQL
$dsn = 'mysql:dbname=serasa;host=localhost;charset=utf8';

try{
    $pdo = new PDO($dsn, 'root', '');
}catch (PDOException $e){
    die('Database connection error -- ' . $e->getMessage());
}

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views'
));

$app->register(new Silex\Provider\SessionServiceProvider());

// Main page using Twig resource
$app->get('/', function () use ($app) {
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
        return $app->redirect('login');
    }
    
    return $app['twig']->render('app.php');
});

$app->get('/login', function() use($app){
    return $app['twig']->render('login.php');
});

$app->post('/session', function(Request $request) use($app, $pdo){
    $data = json_decode($request->getContent(), true);
    
    $user = $data['user'];
    $pass = $data['pass'];
    $pass = md5($pass);
    
    try{
        $sql = "select * from sr_users where binary username like :username and passwd like :passwd ";
        $data = ['username' => $user, 'passwd' => $pass];
        $sth = $pdo->prepare($sql);
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        $json['auth'] = false;
        
        if(count($result) > 0){
            $app['session']->set('user', array('username' => $result[0]['username']));
            $json['auth'] = true;
        }
        
        return $app->json($json);
    }catch(PDOException $e){
        
    }
});

$app->get('/logout', function() use ($app){
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
        return $app->json([]);
    }
    
    $app['session']->set('user', array('username' => null));
    return $app->json(['logout' => true]);
});

$app->get('/clients', function(Request $request) use($app, $pdo){
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
       return $app->json([]);
    }
    
    $ID = $request->get('ID');
    
    $sql = "select
                *,
                if(date_birth = '' or date_birth = '0000-00-00', '', date_format(date_birth, '%d/%m/%Y')) date_birth_format
            from
                sr_clients ";
    
    $sql .= " where 1=1 ";
    
    $execute = [];
    
    if(!empty($ID)){
        $sql .= " and ID = :ID ";
        $execute[':ID'] = $ID;
    }
    
    $sql .= " order by ID desc ";
    
    $sth = $pdo->prepare($sql);
    $sth->execute($execute);
    $clients = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    return $app->json($clients);
});

$app->post('/clients-action', function(Request $request) use($app, $pdo){
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
        return $app->json([]);
    }
    
    $data = json_decode($request->getContent(), true);
    
    try{
        $sql = "insert into
                    sr_clients
                values
                    (null, :name, :email, :phone, :date_birth)";
        
        $sth = $pdo->prepare($sql);
        $sth->execute($data);
        $ID = $pdo->lastInsertId();
        $sth = null;
        
        $sql = "insert into
                    sr_clients_logs
                values
                    (null, :ID_client, :date_action, :action_type)";
        
        $sth = $pdo->prepare($sql);
        $data = ['ID_client' => $ID, 'date_action' => date('Y-m-d H:i:s'), 'action_type' => 'INSERT'];
        $sth->execute($data);
        $sth = null;
        
        return $app->json(['success' => true]);
    }catch (PDOException $e){
        return $app->json(['success' => false]);
    }
});

$app->put('/clients-action', function(Request $request) use($app, $pdo){
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
        return $app->json([]);
    }
    
    $data = json_decode($request->getContent(), true);
    
    try{
        $ID = $data['ID'];
        
        $sql = "update
                    sr_clients
                set
                    name = :name,
                    email = :email,
                    phone = :phone, 
                    date_birth = :date_birth
                where
                    ID = :ID";
        
        $sth = $pdo->prepare($sql);
        $sth->execute($data);
        $sth = null;
        
        $sql = "insert into
                    sr_clients_logs
                values
                    (null, :ID_client, :date_action, :action_type)";
        
        $sth = $pdo->prepare($sql);
        $data = ['ID_client' => $ID, 'date_action' => date('Y-m-d H:i:s'), 'action_type' => 'UPDATE'];
        $sth->execute($data);
        $sth = null;
        
        return $app->json(['success' => true]);
    }catch (PDOException $e){
        return $app->json(['success' => false]);
    }
});

$app->delete('/clients-action/{id}', function($id) use($app, $pdo){
    $user = $app['session']->get('user');
    
    if(null === $user['username']){
        return $app->json([]);
    }
    
    try{
        $sth = $pdo->prepare('delete from sr_clients where ID = ?');
        $sth->execute([$id]);
        $sth = null;
        
        $sql = "insert into
                    sr_clients_logs
                values
                    (null, :ID_client, :date_action, :action_type)";
        
        $sth = $pdo->prepare($sql);
        $data = ['ID_client' => $id, 'date_action' => date('Y-m-d H:i:s'), 'action_type' => 'DELETE'];
        $sth->execute($data);
        $sth = null;
        
        return $app->json(['success' => true]);
    }catch (PDOException $e){
        return $app->json(['success' => true]);
    }
});

$app->run();