<?php

    namespace Antomarsi\Controller;

    use Silex\Application;
    use Silex\Api\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\Request;
    
    class UserController implements ControllerProviderInterface {

		/*
		 * Register all the routes to this Controller
		 */
        public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
            $controllers->get('/', self::class.'::index')->bind('user-index');
            $controllers->get('/{id}', self::class.'::show')->bind('user-show');
            $controllers->put('/{id}', self::class.'::store')->bind('user-store');
            $controllers->put('/', self::class.'::update')->bind('user-update');
            $controllers->delete('/{id}', self::class.'::delete')->bind('user-delete');
            return $controllers;
        }

		/*
		 * Show All User Registries
		 */
		public function index(Application $app){
			$users = $app['db']->fetchAll('SELECT * FROM users');
			return $app->json($users);
		}
		/*
		 * Show one User Registry with $id
		 */
		public function show(Application $app, $id){
			$users = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id);
			return $app->json($users);
		}
		/*
		 * Create a new User Registry
		 */
		public function store(Application $app, Request $request){
			$dados = json_decode($request->getContent(), true);

			$app['db']->insert('users', array(
				'name' => $dados['name'],
				'email' => $dados['email'],
				'date_birth' => $dados['date_birth'],
				'address' => $dados['address'],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			));
			$user = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$app['db']->lastInsertId());
			return $app->json($user);
		}
		/*
		 * Update a existing User Registry with id = $id
		 */
		public function update(Application $app, Request $request){
			$dados = json_decode($request->getContent(), true);
			$app['db']->update('users', $dados, array('id' => $id));

			return $app->json($app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id));
		}
		/*
		 * Delete a existing User Registry with id = $id
		 */
		public function delete(Application $app, $id){
			$user = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id);
			$app['db']->delete('users', array('id' => $id));
			return $app->json($user);
		}

    }
    