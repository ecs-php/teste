<?php

define('APP_ROOT', dirname(__DIR__));
chdir(APP_ROOT);

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception;
use TestRest\Entity\Entity;
use TestRest\Contact\Contact;
use TestRest\User\User;

require 'vendor/autoload.php';

$app = new Application();

$app['debug'] = true;

$app['timezone'] = 'America/Sao_Paulo';
$app['connection'] = [
    'host' => 'localhost',
    'database' => 'test_rest',
    'user' => 'root',
    'pass' => 'paes'
];

//return PDO connection
$app['connPDO'] = function(Application $app) {
  $pdo = new \PDO('mysql:host=' . $app['connection']['host'] . ';dbname=' . $app['connection']['database'], $app['connection']['user'], $app['connection']['pass']);
  $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  return $pdo;
};

//return Entity Contact
$app['entityContact'] = function(Application $app) {
  $pdo = $app['connPDO'];
  return new Entity($pdo);
};

//return Entity Contact
$app['entityUser'] = function(Application $app) {
  $pdo = $app['connPDO'];
  return new Entity($pdo);
};

//return login user
$app['validUser'] = function(Application $app, $token) {
  return token;
};

//return Current datetime
$app['currentDateTime'] = function(Application $app) {
  date_default_timezone_set($app['timezone']);
  return date('Y-m-d H:i', strtotime("now"));
};

//return Current date
$app['currentDate'] = function(Application $app) {
  date_default_timezone_set($app['timezone']);
  return date('Y-m-d', strtotime("now"));
};

// -------------------------------User--------------------------------------
$app->get('api/v1/users', function (Application $app) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  try {
    $objUser = new User($app['entityUser']);
    $return['data'] = $objUser->getEntity()->getAll();

    return $app->json($return);
  } catch (PDOException $ex) {
    $return['status'] = false;
    $return['message'] = $ex->getMessage();
    return $app->json($return);
  }
});

$app->get('api/v1/users/{id}', function (Application $app, $id) {
          $return = [
              'data' => [],
              'status' => true,
              'message' => ''
          ];
          try {
            $objUser = new User($app['entityUser']);
            $return['data'] = $objUser->getEntity()->getById($id);

            return $app->json($return);
          } catch (PDOException $ex) {
            $return['status'] = false;
            $return['message'] = $ex->getMessage();
            return $app->json($return);
          }
        })
        ->convert('id', function($id) {
          return (int) $id;
        });

$app->post('api/v1/users', function (Application $app, Request $request) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    try {
      $data = json_decode($request->getContent(), true);

// Fields required
      $user['name'] = (string) empty($data['name']) ? null : $data['name'];
      $user['email'] = (string) empty($data['email']) ? null : $data['email'];
      $user['password'] = (string) empty($data['password']) ? null : md5($data['password']);
      $user['create_date'] = $app['currentDateTime'];

      $objUser = new User($app['entityUser']);
      $return['data'] = $objUser->getEntity()->save($user);

      return $app->json($return);
    } catch (PDOException $ex) {
      $return['status'] = false;
      $return['message'] = $ex->getMessage();
      return $app->json($return);
    }
  } else {
    $return['status'] = false;
    $return['message'] = 'Invalid Input. Only "application/json" message is allowed';
    return $app->json($return);
  }
});

$app->put('api/v1/users', function (Application $app, Request $request) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    try {
      $data = json_decode($request->getContent(), true);

// Fields required
      $user['id_user'] = (int) empty($data['id_user']) ? null : $data['id_user'];
      $user['name'] = (string) empty($data['name']) ? null : $data['name'];
      $user['email'] = (string) empty($data['email']) ? null : $data['email'];
      $user['password'] = (string) empty($data['password']) ? null : md5($data['password']);
      $user['update_date'] = $app['currentDateTime'];

      $objUser = new User($app['entityUser']);
      $return['data'] = $objUser->getEntity()->save($user);

      return $app->json($return);
    } catch (PDOException $ex) {
      $return['status'] = false;
      $return['message'] = $ex->getMessage();
      return $app->json($return);
    }
  } else {
    $return['status'] = false;
    $return['message'] = 'Invalid Input. Only "application/json" message is allowed';
    return $app->json($return);
  }
});

$app->delete('api/v1/users/{id}', function (Application $app, $id) {
          $return = [
              'data' => [],
              'status' => true,
              'message' => ''
          ];
          try {
            $objUser = new User($app['entityUser']);
            $return['data'] = $objUser->getEntity()->delete($id);

            return $app->json($return);
          } catch (PDOException $ex) {
            $return['status'] = false;
            $return['message'] = $ex->getMessage();
            return $app->json($return);
          }
        })
        ->convert('id', function($id) {
          return (int) $id;
        });

// -------------------------------End User--------------------------------------
// 
// Request access token
$app->post('auth', function (Application $app, Request $request) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    try {
      $data = json_decode($request->getContent(), true);

// Fields required
      $user['email'] = (string) empty($data['email']) ? '' : $data['email'];
      $user['password'] = (string) empty($data['password']) ? '' : md5($data['password']);

      $objUser = new User($app['entityUser']);
      $userLogin = $objUser->login($user['email'], $user['password']);

      if ((count($userLogin) > 0) && ($userLogin[0]['email'] == $user['email']) && ($userLogin[0]['password'] == $user['password'])) {
        $tokenJS = json_encode(
                [
                    'e' => $userLogin[0]['email'],
                    'p' => $userLogin[0]['password']
                ]
        );
        $token = base64_encode($tokenJS);
        $return['data'] = ['token' => $token];
      } else {
        $return['status'] = false;
        $return['message'] = 'Invalid e-mail or password';
      }

      return $app->json($return);
    } catch (PDOException $ex) {
      $return['status'] = false;
      $return['message'] = $ex->getMessage();
      return $app->json($return);
    }
  } else {
    $return['status'] = false;
    $return['message'] = 'Invalid Input. Only "application/json" message is allowed';
    return $app->json($return);
  }
});

// Redirect for API detail
$app->get('/', function (Application $app) {
  return $app->redirect('api/v1');
});

// API detail
$app->get('api/v1', function () {
  return 'Detail from API:<br>For get all contacts use "api/vi/contacts"';
});

// Find all resource
$app->get('api/v1/contacts', function (Application $app) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  try {
    $objContact = new Contact($app['entityContact']);
    $return['data'] = $objContact->getEntity()->getAll();

    return $app->json($return);
  } catch (PDOException $ex) {
    $return['status'] = false;
    $return['message'] = $ex->getMessage();
    return $app->json($return);
  }
});

// Find resource by id
$app->get('api/v1/contacts/{id}', function (Application $app, $id) {
          $return = [
              'data' => [],
              'status' => true,
              'message' => ''
          ];
          try {
            $objContact = new Contact($app['entityContact']);
            $return['data'] = $objContact->getEntity()->getById($id);

            return $app->json($return);
          } catch (PDOException $ex) {
            $return['status'] = false;
            $return['message'] = $ex->getMessage();
            return $app->json($return);
          }
        })
        ->convert('id', function($id) {
          return (int) $id;
        });

// Create resource
$app->post('api/v1/contacts', function (Application $app, Request $request) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    try {
      $data = json_decode($request->getContent(), true);

// Fields required
      $contact['name'] = (string) empty($data['name']) ? null : $data['name'];
      $contact['create_date'] = $app['currentDateTime'];

//Fields optional
      if (isset($data['email'])) {
        $contact['email'] = (string) empty($data['email']) ? null : $data['email'];
      }
      if (isset($data['phone'])) {
        $contact['phone'] = (string) empty($data['phone']) ? null : $data['phone'];
      }
      if (isset($data['address'])) {
        $contact['address'] = (string) empty($data['address']) ? null : $data['address'];
      }
      if (isset($data['info'])) {
        $contact['info'] = (string) empty($data['info']) ? null : $data['info'];
      }

      $objContact = new Contact($app['entityContact']);
      $return['data'] = $objContact->getEntity()->save($contact);

      return $app->json($return);
    } catch (PDOException $ex) {
      $return['status'] = false;
      $return['message'] = $ex->getMessage();
      return $app->json($return);
    }
  } else {
    $return['status'] = false;
    $return['message'] = 'Invalid Input. Only "application/json" message is allowed';
    return $app->json($return);
  }
});

// Update resource
$app->put('api/v1/contacts', function (Application $app, Request $request) {
  $return = [
      'data' => [],
      'status' => true,
      'message' => ''
  ];
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    try {
      $data = json_decode($request->getContent(), true);

// Fields required
      $contact['id_contact'] = (int) empty($data['id_contact']) ? null : $data['id_contact'];
      $contact['name'] = (string) empty($data['name']) ? null : $data['name'];
      $contact['update_date'] = $app['currentDateTime'];

//Fields optional
      if (isset($data['email'])) {
        $contact['email'] = (string) empty($data['email']) ? null : $data['email'];
      }
      if (isset($data['phone'])) {
        $contact['phone'] = (string) empty($data['phone']) ? null : $data['phone'];
      }
      if (isset($data['address'])) {
        $contact['address'] = (string) empty($data['address']) ? null : $data['address'];
      }
      if (isset($data['info'])) {
        $contact['info'] = (string) empty($data['info']) ? null : $data['info'];
      }

      $objContact = new Contact($app['entityContact']);
      $return['data'] = $objContact->getEntity()->save($contact);

      return $app->json($return);
    } catch (PDOException $ex) {
      $return['status'] = false;
      $return['message'] = $ex->getMessage();
      return $app->json($return);
    }
  } else {
    $return['status'] = false;
    $return['message'] = 'Invalid Input. Only "application/json" message is allowed';
    return $app->json($return);
  }
});

// Deleting resource
$app->delete('api/v1/contacts/{id}', function (Application $app, $id) {
          $return = [
              'data' => [],
              'status' => true,
              'message' => ''
          ];
          try {
            $objContact = new Contact($app['entityContact']);
            $return['data'] = $objContact->getEntity()->delete($id);

            return $app->json($return);
          } catch (PDOException $ex) {
            $return['status'] = false;
            $return['message'] = $ex->getMessage();
            return $app->json($return);
          }
        })
        ->convert('id', function($id) {
          return (int) $id;
        });

// Validate access
$app->after(function (Request $request) use ($app) {
  $allowAccess = FALSE;
  $pathRequired = [
      "api/v1/contacts"
  ];
  foreach ($pathRequired as $path) {
    $requestPath = $request->getPathInfo();
    if (strpos($requestPath, $path) !== FALSE) {
      $token = $request->headers->get('X-Token');
      if (!empty($token)) {
        $tokenJS = base64_decode($token);
        $tokenArray = json_decode($tokenJS, TRUE);

        if ((count($tokenArray) == 2) && (array_key_exists('e', $tokenArray)) && (array_key_exists('p', $tokenArray))) {

          $objUser = new User($app['entityUser']);
          $userLogin = $objUser->login($tokenArray['e'], $tokenArray['p']);

          if ((count($userLogin) > 0) && ($userLogin[0]['email'] == $tokenArray['e']) && ($userLogin[0]['password'] == $tokenArray['p'])) {
            $allowAccess = TRUE;
          }
        }
      }

      if (!$allowAccess) {
        $return = [
            'data' => [],
            'status' => false,
            'message' => 'Access Denied'
        ];
        return $app->json($return);
      }
    }
  }
});

$app->run();
