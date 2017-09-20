<?php
use Symfony\Component\HttpFoundation\Request;

$api = $app['controllers_factory'];

$api->get('/{apiClass}/', function (Request $request, \Silex\Application $app, $apiClass) {
  $classBuild = '\\Tgenuino\\'.$apiClass;
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'listTasks'], array($request, $app));
})
  ->before($isAuth);

$api->get('/{apiClass}/{id}', function (Request $request, \Silex\Application $app, $apiClass, $id) {
  $classBuild = '\\Tgenuino\\'.$apiClass;
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'getTaskById'], array($request, $app, $id));
})
  ->before($isAuth);

$api->put('/{apiClass}/{id}', function (Request $request, \Silex\Application $app, $apiClass, $id) {
  $classBuild = '\\Tgenuino\\'.$apiClass;
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'updateTask'], array($request, $app, $id));
})
  ->before($isAuth);

$api->post('/{apiClass}/', function (Request $request, \Silex\Application $app, $apiClass) {
  $classBuild = '\\Tgenuino\\'.$apiClass;
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'insertTask'], array($request, $app));
})
  ->before($isAuth);

$api->delete('/{apiClass}/', function (Request $request, \Silex\Application $app, $apiClass) {
  $classBuild = '\\Tgenuino\\'.$apiClass;
  $instance = new $classBuild($app);
  return call_user_func_array([$instance, 'deleteTask'], array($request, $app));
})
  ->before($isAuth);

return $api;