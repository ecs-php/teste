<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 02:00
 */

namespace Common\Services\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractController
 * @package Common\Services\Responder
 */
abstract class AbstractController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    protected function getJsonParameters(Request $request)
    {
        $content = json_decode($request->getContent());

        if (is_null($content)) {
            throw new \Exception('Formato do JSON inválido.');
        }

        return $content;
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return JsonResponse
     */
    protected function createResponse($data = [], $code = 200, $message = 'Requisição efetuada com sucesso.')
    {
        $response = ['code' => $code, 'message' => $message, 'data' => $data];
        return new JsonResponse($response);
    }
}
