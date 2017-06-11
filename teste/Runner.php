<?php


namespace TESTE;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use TESTE\Controller\Person as PersonController;
use TESTE\Controller\User as UserController;
use \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

use \Exception;

/**
 * Description of Runner
 *
 * @author pandacoder
 */
class Runner {
    public function run()
    {
        $app = new Application();
        $app['debug'] = true;
        
        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            } else {
                throw new Exception("Accept json data only!");
            }
        });
        
        
        $app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__. DIRECTORY_SEPARATOR . 'teste.db',
            ),
        ));
        
        
        $app->register(new DoctrineOrmServiceProvider, array(
            'orm.em.options' => array(
                'mappings' => array(
                    array(
                        'type' => 'annotation',
                        'namespace' => 'TESTE\Entity',
                        'path' => __DIR__.'/Entity',
                        "use_simple_annotation_reader" => false,
                    )
                ),
            ),
        ));

        
        $app->post('/person/', function(Request $request) use($app) {
         
            $person = new PersonController($app);
            
            $action = $request->request->get('action') . 'Action';
            
            if (method_exists($person, $action)){
                $user = new UserController($app);
                $user->authenticate($request);


                $response = call_user_func_array(array($person, $action), array($request));
            } else {
                $response = array('message' => 'Route not found!');
            }
            
            
            return $app->json($response, 201);
        });

        $app->post('/singup/', function(Request $request) use($app) {

            $user = new UserController($app);


            $response = $user->singupAction($request);


            return $app->json($response, 201);
        });

    
        
         $app->get('/setup/', function() use($app) {
             
             
            return 'Setup ';
        });
        
        $app->error(function (\Exception $e, $code) use($app){
            $response = array(
                'message' => $e->getMessage()
            );

            return $app->json($response, 500);
        });
        
        
        $app->run();
    }
}
