<?php

//ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';
include 'database.php';

use API\Models\Winner;
//use Chatter\Middleware\Logging as APILogging;
use API\Middleware\Authentication as APIAuth;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;


$app = new Silex\Application();
$app->before(function($request, $app) {
  // APILogging::log($request, $app);
  APIAuth::authenticate($request, $app);
});

// DEV set true
$app['debug'] = true;

// LIST WINNERS

$app->get('/winners', function() use ($app) {
  $_winner = new Winner();

  $_winners = $_winner->all();

  $payload = [];

  foreach($_winners as $_win) {
    $payload[$_win->id] =
      [
        'userId' => $_win->userId,
        'winnerName' => $_win->winnerName,
        'winnerEmail' => $_win->winnerEmail,
        'winnerCpf' => $_win->winnerCpf,
        'winnerCity' => $_win->winnerCity,
        'winnerState' => $_win->winnerState,
        'created_at' => $_win->created_at,
        'updated_at' => $_win->updated_at
      ];
  }

  return json_encode($payload);

});

// LIST WINNER BY ID

$app->get('/winner/{winner_id}', function($winner_id) use ($app) {
  $_winner = new Winner();

  $_winner = Winner::find($winner_id);

  if($_winner->exists) {
    return json_encode($_winner);
  } else {
    return new Response('No Content', 204);
  }

});

// ALTER WINNER BY ID

$app->post('/winner/alter/{winner_id}', function(Request $request, $winner_id) use ($app) {

  // Load data POST form
  $_winnerName            = $request->get('winnerName');
  $_winnerEmail           = $request->get('winnerEmail');
  $_winnerCpf             = $request->get('winnerCpf');
  $_winnerCity            = $request->get('winnerCity');
  $_winnerState           = $request->get('winnerState');

  $winner = new Winner();
  $winner = Winner::find($winner_id);

  $winner->userId         = 1; // only usér apikey fixed in code
  $winner->winnerName     = $_winnerName;
  $winner->winnerEmail    = $_winnerEmail;
  $winner->winnerCpf      = $_winnerCpf;
  $winner->winnerCity     = $_winnerCity;
  $winner->winnerState    = $_winnerState;
  $winner->save();

  //return JSON update WINNER

  if ($winner->id) {
    $payload = [
      'winnerName' => $winner->winnerName,
      'winnerEmail' => $winner->winnerEmail,
      'winnerCpf' => $winner->winnerCpf,
      'winnerCity' => $winner->winnerCity,
      'winnerState' => $winner->winnerState,
    ];
    $code = 201;
  } else {
    $code = 400;
    $payload = [];
  }

  return $app->json($payload, $code);

});

// CREATE NEW WINNER

$app->post('/winner/create', function(Request $request) use ($app) {
  // Load data POST form
  $_winnerName            = $request->get('winnerName');
  $_winnerEmail           = $request->get('winnerEmail');
  $_winnerCpf             = $request->get('winnerCpf');
  $_winnerCity            = $request->get('winnerCity');
  $_winnerState           = $request->get('winnerState');

  // Insert POST data in TABLE winners
  $winner = new Winner();
  $winner->userId         = 1; // only usér apikey fixed in code
  $winner->winnerName     = $_winnerName;
  $winner->winnerEmail    = $_winnerEmail;
  $winner->winnerCpf      = $_winnerCpf;
  $winner->winnerCity     = $_winnerCity;
  $winner->winnerState    = $_winnerState;
  $winner->save();

  //return JSON new WINNER

  if ($winner->id) {
    $payload = [
      'winnerName' => $winner->winnerName,
      'winnerEmail' => $winner->winnerEmail,
      'winnerCpf' => $winner->winnerCpf,
      'winnerCity' => $winner->winnerCity,
      'winnerState' => $winner->winnerState,
    ];
    $code = 201;
  } else {
    $code = 400;
    $payload = [];
  }

  return $app->json($payload, $code);

});

// return JSON delete WINNER

$app->delete('/winner/delete/{winner_id}', function($winner_id) use ($app) {
  $winner = Winner::find($winner_id);

  if($winner->exists) {
    $winner->delete();
    $payload = [
      'winnerName' => $winner->winnerName,
      'winnerEmail' => $winner->winnerEmail,
      'winnerCpf' => $winner->winnerCpf,
      'winnerCity' => $winner->winnerCity,
      'winnerState' => $winner->winnerState,
    ];
    $code = 200;

    return $app->json($payload, $code);
  } else {
    return new Response('No Content', 204);
  }

});

$app->run();
