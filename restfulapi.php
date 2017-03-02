<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$authorized = false;
$a = base64_decode( substr($_SERVER["REMOTE_USER"],6)) ;
if ( (strlen($a) == 0) || ( strcasecmp($a, ":" )  == 0 ))
{
	header( 'WWW-Authenticate: Basic realm="Private"' );
	header( 'HTTP/1.0 401 Unauthorized' );
} else {
	list($name, $password) = explode(':', $a);
	if (($name == 'admin' and $password == 'admin') or ($name == 'user' and $password == 'user')){
		$authorized = true;
	}
}

$app = new Silex\Application ();
// production environment - false; test environment - true
$app ['debug'] = true;

/* Connect to sqlite atabase */
date_default_timezone_set ( 'America/Sao_Paulo' );
$dsn = 'sqlite:test.sqlite3';
try {
	$file_db = new PDO ( $dsn );
	$file_db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	echo 'Connection failed: ' . $e->getMessage ();
}

try {
	
	$file_db->exec ( "CREATE TABLE IF NOT EXISTS PERSON
	      (ID 			 INTEGER PRIMARY KEY,
	      NAME           TEXT    NOT NULL,
	      AGE            INTEGER NOT NULL,
	      EMAIL          TEXT NOT NULL,
	      GENDER         TEXT NOT NULL,
		  PHONE			 TEXT NOT NULL,
		  DATECREATED	 TEXT NOT NULL,
		  DATEUPDATED    TEXT NOT NULL);" );
} catch ( PDOException $e ) {
	// Print PDOException message
	echo $e->getMessage ();
}

/* Rotas */
$app->get ( '/people', function () use ($app, $file_db, $authorized) {

	if (!$authorized) {
		return new Response ( "authorization failed", 401, array('WWW-Authenticate: Basic realm="Teste"', 'HTTP/1.0 401 Unauthorized') );
	}
	
	$stmt = $file_db->prepare ( 'SELECT ID, NAME, AGE, EMAIL, GENDER, PHONE, DATECREATED, DATEUPDATED FROM PERSON' );
	$stmt->execute ();
	$people = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	
	if (count ( $people ) == 0) {
		/**
		 * ************************************
		 * Set initial data *
		 * ************************************
		 */
		
		// Array with some test data to insert to database
		$person = array (
				array (
						'id' => 1,
						'name' => 'Joaquim',
						'age' => 20,
						'email' => 'joaquim@test.com',
						'gender' => 'M',
						'phone' => '(11)123456789',
						'datecreated' => '01/03/2017 17:00:00',
						'dateupdated' => '01/03/2017 17:00:00' 
				),
				array (
						'id' => 2,
						'name' => 'Maria',
						'age' => 22,
						'email' => 'maria@test.com',
						'gender' => 'F',
						'phone' => '(11)987654321',
						'datecreated' => '01/03/2017 17:00:00',
						'dateupdated' => '01/03/2017 17:00:00' 
				),
				array (
						'id' => 3,
						'name' => 'Pedro',
						'age' => 20,
						'email' => 'pedro@test.com',
						'gender' => 'M',
						'phone' => '(11)44445555',
						'datecreated' => '01/03/2017 17:00:00',
						'dateupdated' => '01/03/2017 17:00:00' 
				) 
		);
		
		// Prepare INSERT statement to SQLite file db
		$insert = "INSERT INTO PERSON (NAME, AGE, EMAIL, GENDER, PHONE, DATECREATED, DATEUPDATED)
	                VALUES (:name, :age, :email, :gender, :phone, :datecreated, :dateupdated )";
		$stmt = $file_db->prepare ( $insert );
		
		// Bind parameters to statement variables
		// $stmt->bindParam ( ':id', $id );
		$stmt->bindParam ( ':name', $name );
		$stmt->bindParam ( ':age', $age );
		$stmt->bindParam ( ':email', $email );
		$stmt->bindParam ( ':gender', $gender );
		$stmt->bindParam ( ':phone', $phone );
		$stmt->bindParam ( ':datecreated', $datecreated );
		$stmt->bindParam ( ':dateupdated', $dateupdated );
		
		// Loop thru all person and execute prepared insert statement
		foreach ( $person as $m ) {
			// Set values to bound variables
			// $id = $m ['id'];
			$name = $m ['name'];
			$age = $m ['age'];
			$email = $m ['email'];
			$gender = $m ['gender'];
			$phone = $m ['phone'];
			$datecreated = date ( "d-m-Y H:i:s" ); // $m ['datecreated'];
			$dateupdated = date ( "d-m-Y H:i:s" ); // $m ['dateupdated'];
			                                       
			// Execute statement
			$stmt->execute ();
		}
		
		$stmt = $file_db->prepare ( 'SELECT ID, NAME, AGE, EMAIL, GENDER, PHONE, DATECREATED, DATEUPDATED FROM PERSON' );
		$stmt->execute ();
		$people = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	return $app->json ( $people );
} );

$app->get ( '/person/{id}', function ($id) use ($app, $file_db, $authorized) {

	if (!$authorized) {
		return new Response ( "authorization failed", 401, array('WWW-Authenticate: Basic realm="Teste"', 'HTTP/1.0 401 Unauthorized') );
	}
	
	$stmt = $file_db->prepare ( 'SELECT ID, NAME, AGE, EMAIL, GENDER, PHONE, DATECREATED, DATEUPDATED FROM PERSON WHERE ID=?' );
	$stmt->execute ( [ 
			$id 
	] );
	
	$person = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	if (empty ( $person )) {
		return new Response ( "Person with id {$id} not found!", 404 );
	}
	
	return $app->json ( $person );
} );

$app->delete ( '/person/{id}', function ($id) use ($app, $file_db, $authorized) {

	if (!$authorized) {
		return new Response ( "authorization failed", 401, array('WWW-Authenticate: Basic realm="Teste"', 'HTTP/1.0 401 Unauthorized') );
	}
	
	$stmt = $file_db->prepare ( 'DELETE FROM PERSON WHERE ID = ?' );
	$stmt->execute ( [ 
			$id 
	] );
	
	if ($stmt->rowCount () < 1) {
		return new Response ( "Person with id {$id} not found for exclusion!", 404 );
	}
	//204 - no content
	return new Response ( null, 204 );
} );

$app->post ( '/person', function (Request $request) use ($app, $file_db, $authorized) {

	if (!$authorized) {
		return new Response ( "authorization failed", 401, array('WWW-Authenticate: Basic realm="Teste"', 'HTTP/1.0 401 Unauthorized') );
	}
	
	$data = json_decode ( $request->getContent (), true );
	$data ['datecreated'] = date ( "d-m-Y H:i:s" );
	$data ['dateupdated'] = date ( "d-m-Y H:i:s" );
	$stmt = $file_db->prepare ( "INSERT INTO PERSON (NAME, AGE, EMAIL, GENDER, PHONE, DATECREATED, DATEUPDATED)
	                VALUES (:name, :age, :email, :gender, :phone, :datecreated, :dateupdated )" );
	try {
		$stmt->execute ( $data );
		$id = $file_db->lastInsertId ();
	} catch ( PDOException $e ) {
		return new Response ( json_encode ( $data ), 404 );
	}
	
	// response, 201 created
	$response = new Response ( 'Ok', 201 );
	return $response;
} );

$app->put ( '/person/{id}', function (Request $request, $id) use ($app, $file_db, $authorized) {

	if (!$authorized) {
		return new Response ( "authorization failed", 401, array('WWW-Authenticate: Basic realm="Teste"', 'HTTP/1.0 401 Unauthorized') );
	}
	
	$data = json_decode ( $request->getContent (), true );
	$data ['dateupdated'] = date ( "d-m-Y H:i:s" );
	$data ['id'] = $id;
	
	$sth = $file_db->prepare ( 'UPDATE PERSON
            SET NAME=:name, AGE=:age, EMAIL=:email, GENDER=:gender, PHONE=:phone, DATEUPDATED=:dateupdated
            WHERE id=:id' );
	try {
		$sth->execute ( $data );
	} catch ( PDOException $e ) {
		return new Response ( json_encode ( $data ), 404 );
	}
	return $app->json ( $data, 200 );
} );

$app->run ();

?>