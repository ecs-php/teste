<?php

namespace Rest\Controllers;

use Domain\Winner\WinnerRespository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WinnersController
 *
 * @package Rest\Controllers
 */
class WinnersController
{
    /**
     * @var WinnerRespository
     */
    private $winnerRespository;

    /**
     * WinnersController constructor.
     *
     * @param WinnerRespository $winnerRespository
     */
    public function __construct(WinnerRespository $winnerRespository)
    {
        $this->winnerRespository = $winnerRespository;
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return new JsonResponse($this->winnerRespository->findAll(), 200);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function find($id)
    {
        $winner = $this->winnerRespository->find($id);
        if (!$winner) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        return new JsonResponse($winner, 200);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function save(Request $request)
    {
        if($this->winnerRespository->hasErrors($request)){
            return new JsonResponse($this->winnerRespository->hasErrors($request), 400);
        }
        return new JsonResponse($this->winnerRespository->create($request), 201);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $winner = $this->winnerRespository->find($id);
        if (!$winner) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        if($this->winnerRespository->hasErrors($request)){
            return new JsonResponse($this->winnerRespository->hasErrors($request), 400);
        }

        return new JsonResponse($this->winnerRespository->update($request, $winner), 204);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $winner = $this->winnerRespository->find($id);
        if (!$winner) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        return new JsonResponse($this->winnerRespository->delete($id), 204);
    }
}