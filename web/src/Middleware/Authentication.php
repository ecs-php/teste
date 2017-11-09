<?php
namespace Hmarinjr\RESTFulAPI\Middleware;

use Hmarinjr\RESTFulAPI\Model\Client;

class Authentication
{
	public static function authenticate($request, $app)
	{ 
		$auth = $request->headers->get("Authorization");
		$apikey = substr($auth, strpos($auth, ' '));
		$apikey = trim($apikey);
		$client = new Client();
		$check = $client->authenticate($apikey);

		if (!$check) {
		   $app->abort(401);
		   return 'Unauthorized';
		}

		$request->attributes->set('userid',$check);
	}
}