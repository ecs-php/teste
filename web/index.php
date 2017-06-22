<?php
	date_default_timezone_set('America/Sao_Paulo');
	require_once __DIR__ . '/../vendor/autoload.php';
	
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	
	define("ROOT_PATH", __DIR__ . "/..");
	
	$app = new Silex\Application();
	$dsn = "mysql:dbname=video_repository_db;host=LOCALHOST;charset=utf8";
	try {
	$dbh = new PDO($dsn, 'root', '123qwe');
	} catch (PDOException $e) {
	echo 'Error DB: ' . $e->getMessage();
	}
	
	/**
	 * Start listing of videos
	 */
	$app->get('/videos', function (Request $request) use ($app, $dbh) {
		
		$accessToken = $request->query->get("access_token");
		
		if( $accessToken ) {
		 $userData = getUserData($accessToken,$app,$dbh);
		 
		 if( $userData ) {
			 $videoTitle = $request->query->get("title");
			
			 $sql = 'SELECT id, title, description, duration FROM video WHERE active=?';
			 $params = array("yes");
			
			 if( $videoTitle ){
				 $sql .= " AND title LIKE ?" ;
				 $params[] = "%".$videoTitle."%";
			 }
			
			 $sth = $dbh->prepare($sql);
			 $sth->execute($params);
			 $videoRs = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			 if(empty($videoRs)) {
				 return new Response("Nenhum resultado encontrado para a busca: '".  $request->query->get("title")."'", 404);
			 }
			
			 return $app->json($videoRs);
		 }
		}
		
		return new Response("Access Token inválido: ", 404);
		
	});
	
	/**
	 * Criando um vídeo
	 *
	 */
	$app->post('/videos', function(Request $request) use ($app, $dbh) {
		$insertData = json_decode($request->getContent(), true);
		
		
		$accessToken = $request->query->get("access_token");
		
		if( $accessToken ) {
			$userData = getUserData( $accessToken , $app , $dbh );
			if ( $userData ) {
				$sth = $dbh->prepare(
					'INSERT INTO video ( title,category_id,description,filename,duration,active,creation_date)
		VALUES(:title, :category_id, :description,:filename,:duration,:active,NOW())'
				);
				$sth->execute( $insertData );
				$response = new Response( 'Ok' , 201 );
				
				return $response;
			}
			
		}
		
		return new Response("Access Token inválido: ", 404);
		
	
	});
	
	/**
	 * User info
	 *
	 * @param $accessToken
	 * @param $app
	 * @param $dbh
	 * @return bool
	 */
	function getUserData ( $accessToken, $app,$dbh ) {
		$sql = "SELECT user.* FROM user
			LEFT JOIN user_access_token ON ( user_access_token.user_id =user.id )
 			WHERE user.active=? AND
 			 user_access_token.active=? AND
				user_access_token.access_token=? ";

		$params = array("yes" , "yes" , $accessToken );

		$sth = $dbh->prepare($sql);
	
		$sth->execute($params);

		$userRs = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		
		if(!empty($userRs)) {
			
			return $app->json($userRs);
		}
	
		return false;
	}
	
	/**
	 * User Edit
	 */
	$app->put('/videos/{title}', function(Request $request, $title) use ($app, $dbh) {
		$videoData = json_decode($request->getContent(), true);
		
		
		
		$accessToken = $request->query->get("access_token");
		
		if( $accessToken ) {
			$userData = getUserData( $accessToken , $app , $dbh );
			if ( $userData ) {
				$sth = $dbh->prepare(
					'UPDATE video
		SET title=:title, description=:description, duration=:duration
		WHERE id=:id'
				);
				$sth->execute( $videoData );
				
				return $app->json( $videoData , 200 );
			}
		}
		
		
		return new Response("Access Token inválido: ", 404);
		
	})->assert('title', '\w+');

	
	$app->run();