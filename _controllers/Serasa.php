<?php
namespace Tgenuino;

use Symfony\Component\HttpFoundation\JsonResponse;

class Serasa {
  function __construct($app) {
    $this->app = $app;
  }

  function listWinners($request, $app) {
    $results = [
      
    ];

    for ($i = 0, $x=6; $i < $x; $i++) {
      $results[] = [
        'id' => $i,
        'date' => '17/08',
        'city' => 'São Paulo',
        'state' => 'SP',
        'no' => '053484058978-9'
      ];
    }

    return new JsonResponse(array(
      'results' => $results
    ));
  }

  function listDoorPrizeDates($request, $app) {
    $results = [
      
    ];

    for ($i = 0, $x=20; $i < $x; $i++) {
      $results[] = [
        'id' => $i,
        'date' => '17/08',
      ];
    }

    return new JsonResponse(array(
      'results' => $results
    ));
  }
}

?>