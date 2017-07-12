<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Model\Person;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->before(function(Request $request, $app) use ($app){
    if (0 == strpos($request->headers->get('Content-Type'), 'application/json')) {
		$data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
	}else{
        return $app->json(array('message' => 'Invalid Header Content-Type'), 403);
    }
});

$app->mount('/api', function ($mount) use ($app){

	$mount->get('/person', function () use ($app) {
		$person = Person::all();
		return $app->json($person, 201);
	});
	
	$mount->get('/person/{id}', function ($id) use ($app) {
		$person = Person::find($id);
		return $app->json($person, 201);
	});

	$mount->put('/person', function (Request $request) use ($app) {
		try{
			$person = new Person($request->request->all());
			$person ->save();
		} catch (Exception $e){
			return $app->json(array('message' => 'Invalid data'), 401);
		}
		return $app->json($person ,201);
	});

	$mount->put('/person/{id}', function (Request $request, $id) use ($app) {
		$person = Person::find($id);
		if($person != null){
			try{
				$person->update($request->request->all());
			}catch (Exception $e){
				return $app->json(array('message' => 'Invalid data'), 401);
			}
		}else{
			return $app->json(array('message' => 'Person not found'), 401);
		}
		return $app->json($person, 201);
	});

	$mount->delete('/person/{id}', function ($id) use ($app) {
		$person = Person::find($id);
		if($person != null){
			try{
				$person->delete();
			}catch (Exception $e){
				return $app->json(array('message' => 'Invalid data'), 401);
			}
		}else{
			return $app->json(array('message' => 'Person not found'), 401);
		}
		return $app->json(array('message' => 'Person was deleted successfully'), 201);
	});
});

$app->error(function (Exception $e, $code) use ($app) {
    if ($app['debug'])
        return;
    return $app->json(array('message' => 'An error ocurred'), $code);
});