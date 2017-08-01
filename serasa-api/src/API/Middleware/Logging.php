<?php

namespace API\Middleware;

class Logging {

  public static function log($request, $app) {
    error_log($request->getMethod() . " -- " . $request->getUrl());
  }

}
