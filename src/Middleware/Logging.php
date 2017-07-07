<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 21:10
 */
namespace App\Middleware;

class Logging {

public static function log($request, $app)
{
error_log($request->getMethod() . "--" . $request->getUri());
}




}




?>