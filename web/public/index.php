<?php
require __DIR__ . '/connection.php';
 
use Hmarinjr\RESTFulAPI\Model\Book; 
use Hmarinjr\RESTFulAPI\BookDTO; 
use Hmarinjr\RESTFulAPI\Model\Client; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Hmarinjr\RESTFulAPI\Middleware\Authentication;

$app = new Silex\Application();

$app->before(function($request, $app) {
	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }

    Authentication::authenticate($request, $app);
});

$app ->get('/books', function(Request $request) use ($app) {
	$books = Book::get();
	$dtos = [];

	foreach ($books as $book) {
		$dtos[] = (new BookDTO(
			$book->id,
	        $book->title,
	        $book->author,
	        $book->created_at,
	        $book->launched_at ? new DateTime($book->launched_at) : null,
	        $book->updated_at ? new DateTime($book->updated_at) : null
		))->serialize();
	}
 
 	return $app->json($dtos, 200);
 
});

$app->get('/books/{bookId}', function($bookId) use ($app) {
	$book = Book::find($bookId);

   	$dto = (new BookDTO(
		$book->id,
        $book->title,
        $book->author,
        $book->created_at,
        $book->launched_at ? new DateTime($book->launched_at) : null,
        $book->updated_at ? new DateTime($book->updated_at) : null
	))->serialize();

   	return $app->json($dto, 200); 
});

$app->post('/books', function(Request $request) use ($app) {
    $book = new Book();
 	$book->title = $request->get('title');
	$book->author = $request->get('author');

	if ($request->get('launched_at')){
		$book->launched_at = new DateTime($request->get('launched_at'));
	}

	$book->save();

	if ($book->id) {
	   	$payload = ['book_id' => $book->id, 'message_uri' => '/books/' . $book->id];
	   	$code = 201;
	} else {
	   	$code = 400;
	   	$payload = [];
	}

	return $app->json($payload, $code);
});


$app->put('/books/{bookId}', function($bookId,Request $request) use ($app) {
   	$book = Book::find($bookId);
   	$book->title = $request->get('title');
	$book->author = $request->get('author');

	if ($request->get('launched_at')){
		$book->launched_at = new DateTime($request->get('launched_at'));
	}

   	$book->save();

	if ($book->id) {
	   $payload = ['book_id' => $book->id, 'book_uri' => '/books/' . $book->id];
	   $code = 201;
	} else {
	   $code = 400;
	   $payload = [];
	}

	return $app->json($payload, $code);

});

$app->delete('/books/{bookId}', function($bookId) use ($app) { 
   $book = Book::find($bookId);
   $book->delete();
 
   if ($book->exists) {
       return new Response('', 400); 
   }

   return new Response('', 204); 
});

$app->run();