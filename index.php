<?php

require './_bootstrap.php';

$req = new Request();

try {
  $req->handle();
} catch(Exception $e) {
  $req->sendResponse(500);
}
