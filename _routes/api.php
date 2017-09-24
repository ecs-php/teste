<?php
use Symfony\Component\HttpFoundation\Request;

$api = $app['controllers_factory'];

$api->get('/Serasa/listWinners/', function (Request $request, \Silex\Application $app) {
  $classBuild = '\\Tgenuino\\Serasa';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'listWinners'], array($request, $app));
});

$api->get('/Serasa/listDoorPrizeDates/', function (Request $request, \Silex\Application $app) {
  $classBuild = '\\Tgenuino\\Serasa';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'listDoorPrizeDates'], array($request, $app));
});

$api->get('/Task/', function (Request $request, \Silex\Application $app) {
  $classBuild = '\\Tgenuino\\Task';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'listTasks'], array($request, $app));
})
  ->before($isAuth);

$api->get('/Task/{id}', function (Request $request, \Silex\Application $app, $id) {
  $classBuild = '\\Tgenuino\\Task';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'getTaskById'], array($request, $app, $id));
})
  ->before($isAuth);

$api->put('/Task/{id}', function (Request $request, \Silex\Application $app, $id) {
  $classBuild = '\\Tgenuino\\Task';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'updateTask'], array($request, $app, $id));
})
  ->before($isAuth);

$api->post('/Task/', function (Request $request, \Silex\Application $app) {
  $classBuild = '\\Tgenuino\\Task';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'insertTask'], array($request, $app));
})
  ->before($isAuth);

$api->delete('/Task/', function (Request $request, \Silex\Application $app) {
  $classBuild = '\\Tgenuino\\Task';
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'deleteTask'], array($request, $app));
})
  ->before($isAuth);

return $api;