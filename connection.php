<?php

require 'vendor/autoload.php';
$dsn = 'mysql:dbname=silex_task;host=192.168.104.250;charset=utf8';
try {
    $dbh = new PDO($dsn, 'root', 'flexAr56');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>