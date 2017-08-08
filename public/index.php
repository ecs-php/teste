<?php
    /**
     * @author Cristiano Azevedo <cristianoazevedo@vivaweb.net>
     */

    use App\Entity\User;
    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;


    require '../vendor/autoload.php';

    $app = new Application();

    $app->error(function (\Exception $e) use ($app){
        return new \Symfony\Component\HttpFoundation\Response("Something goes terribly wrong: " . $e->getMessage());
    });

    $app->before(function (Request $request, Application $app){
        $token = $request->headers->get("Token");

        if (!$token) {
            $error = array('message' => 'Header:Token was not found.');

            return $app->json($error, 404);
        }

    }, Application::EARLY_EVENT);

    $app->get('/', function (Application $app){
        return $app->json(['description' => 'Api SERASA', 'version' => '1.0'], 200);
    });

    $app->mount('/user', function ($user){
        $user->get('/', function (Application $app){
            /* @var $entityManager \Doctrine\ORM\EntityManager */
            $entityManager = \App\Connection::getEntityManager();

            $users = $entityManager->getRepository(\App\Entity\User::class)->findAll();

            $users = array_map(function ($user){
                /* @var $user \App\Entity\User */
                return [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'age' => $user->getAge(),
                    'country' => $user->getCountry(),
                    'created' => $user->getCreated(),
                    'updated' => $user->getUpdated()
                ];
            }, $users);

            return $app->json(['count' => count($users), 'users' => $users], 200);
        });

        $user->get('/{id}', function (Application $app, $id){
            $id = $id;

            if (!is_numeric($id)) {
                $error = array('message' => 'Parameter ID must be a integer');

                return $app->json($error, 400);
            }

            $entityManager = \App\Connection::getEntityManager();

            $user = $entityManager->getRepository(\App\Entity\User::class)->find($id);

            if (!$user instanceof \App\Entity\User) {
                $error = array('message' => 'User not found');

                return $app->json($error, 400);
            }

            $userJson = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'age' => $user->getAge(),
                'country' => $user->getCountry(),
                'created' => $user->getCreated(),
                'updated' => $user->getUpdated()
            ];

            return $app->json($userJson, 200);
        });

        $user->post('/', function (Request $request, Application $app){
            $data = $request->request->all();

            $filter = new \App\Filter\User();
            $filter->setData($data);

            if ($filter->isValid()) {
                try{
                    $user = new \App\Entity\User();
                    $user = $user->hydrate($data, $user);

                    $entityManager = \App\Connection::getEntityManager();

                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $app->json(['message' => 'The user was created', 'id' => $user->getId()], 201);
                }catch (\Exception $exception){
                    $error = array(
                        'message' => 'There was a problem creating the user',
                        'exception' => $exception->getMessage()
                    );

                    return $app->json($error, 400);
                }

            }else {
                $error = array('messages' => $filter->getMessages());

                return $app->json($error, 400);
            }
        });

        $user->put('/{id}', function (Request $request, Application $app, $id){
            $id = $id;

            if (!is_numeric($id)) {
                $error = array('message' => 'Parameter ID must be a integer');

                return $app->json($error, 400);
            }

            $entityManager = \App\Connection::getEntityManager();

            $user = $entityManager->getRepository(\App\Entity\User::class)->find($id);

            if (!$user instanceof \App\Entity\User) {
                $error = array('message' => 'User not found');

                return $app->json($error, 400);
            }

            $data = $request->request->all();

            $filter = new \App\Filter\User();
            $filter->setData($data);

            if ($filter->isValid()) {
                try{
                    $data['updated'] = new \DateTime();
                    $object = new User();
                    $user = $object->hydrate($data, $user);

                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $app->json(['message' => 'The user was updated', 'id' => $user->getId()], 200);
                }catch (\Exception $exception){
                    $error = array(
                        'message' => 'There was a problem updating the user',
                        'exception' => $exception->getMessage()
                    );

                    return $app->json($error, 400);
                }

            }else {
                $error = array('messages' => $filter->getMessages());

                return $app->json($error, 400);
            }
        });

        $user->delete('/{id}', function (Application $app, $id){
            $id = $id;

            if (!is_numeric($id)) {
                $error = array('message' => 'Parameter ID must be a integer');

                return $app->json($error, 400);
            }

            $entityManager = \App\Connection::getEntityManager();

            $user = $entityManager->getRepository(\App\Entity\User::class)->find($id);

            if (!$user instanceof \App\Entity\User) {
                $error = array('message' => 'User not found');

                return $app->json($error, 400);
            }

            try{
                $entityManager->remove($user);
                $entityManager->flush();

                return $app->json(['message' => 'The user was removed'], 200);
            }catch (\Exception $exception){
                $error = array('message' => 'There was a problem removing', 'exception' => $exception->getMessage());

                return $app->json($error, 400);
            }
        });
    });

    $app->run();
