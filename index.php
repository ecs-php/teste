<?php

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    
    require 'vendor/autoload.php';
    require 'src/JWTWrapper.php';

    $app = new Application();   
    $app['debug'] = true;

    //TIMEZONE
    date_default_timezone_set('America/Sao_Paulo');
     
    //CONNECT TO DATABASE USING DOCTRINE 
    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => '127.0.0.1',
            'dbname'    => 'db_amcom',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8',
        ),
    ));    

    //ROUTES

    //AUTHENTICATION
    $app->post('/auth', function (Request $request) use ($app) {
        
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $pass = md5($data['pass']);
        
        $sql = "SELECT * FROM tb_auth WHERE email = ? AND pass = ?";
        $res = $app['db']->fetchAssoc($sql, array($email, $pass));
        
        if($email == $res['email'] && $pass == $res['pass']) {            
            //GENERATE TOKEN, VALIDATION OK
            $jwt = JWTWrapper::encode([
                'expiration_sec' => 3600,
                'iss' => 'http://localhost/projetos/teste_amcom',
                'userdata' => [
                    'id' => $res['id_user'],
                    'name' => $res['name']
                ]
            ]);    
            return $app->json([
                'login' => 'true',
                'access_token' => $jwt
            ]);
        }
            return $app->json([
                'login' => 'false',
                'message' => 'Login Inválido',
        ]);

        $teste = "oi";
    });

    //VERIFY AUTHENTICATION 
    $app->before(function(Request $request, Application $app) {
        $route = $request->get('_route'); 
        if($route != 'POST_auth') {
            $authorization = $request->headers->get("Authorize");
            list($jwt) = sscanf($authorization, 'Bearer %s');
    
            if($jwt) {
                try {
                    $app['jwt'] = JWTWrapper::decode($jwt);
                } catch(Exception $ex) {
                    //COULD NOT DECODE
                    return new Response('Unauthorized Access!', 400);
                }     
            } else {
                //COULD NOT EXTRACT TOKEN
                return new Response('Uninvited token', 400);
            }
        }
    });
    
    //LIST ALL DRIVERS
    $app->get('/drivers', function () use ($app) {
        $sql = "SELECT * FROM tb_drivers";
        $res = $app['db']->fetchAll($sql);    
        return $app->json($res);       
    });

    //LIST SPECIFIC DRIVER
    $app->get('/drivers/{id}', function ($id) use ($app) {
        $sql = "SELECT * FROM tb_drivers WHERE id_driver = ?";
        $res = $app['db']->fetchAssoc($sql, array((int) $id));
        return $app->json($res);        
    });
   
    //CREATE DRIVER
    $app->post('/drivers', function(Request $request) use ($app){

        $data = json_decode($request->getContent(), true);
        $creation_date = date("Y-m-d H:i:s");

        $app['db']->insert('tb_drivers', array(
            'name'          => $data['name'],
            'age'           => $data['age'],
            'country'       => $data['country'],
            'city'          => $data['city'],
            'creation_date' => $creation_date
        ));      

        return new Response('Driver included successfully!', 201);    

    });

    //EDIT SPECIFIC DRIVER
    $app->put('/drivers/{id}', function(Request $request, $id) use ($app){

        $data = json_decode($request->getContent(), true);
        $alteration_date = date("Y-m-d H:i:s");

        $app['db']->update('tb_drivers', array(
            'name'          => $data['name'],
            'age'           => $data['age'],
            'country'       => $data['country'],
            'city'          => $data['city'],
            'alteration_date' => $alteration_date
        ),array(
            'id_driver' => $id
        )); 

        return new Response('Driver changed successfully!', 200);     

    });

    //DELETE SPECIFIC DRIVER
    $app->delete('/drivers/{id}', function(Request $request, $id) use ($app){        
        $app['db']->delete('tb_drivers', array( 'id_driver' => $id )); 
        return new Response('Driver deleted successfully!', 204); 
    });
    
    $app->run();

?>