<?php
/**
 * Created by André Felipe de Souza.
 * Date: 07/03/17 23:53
 */

namespace Common\Services\ExceptionHandler;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ExceptionHandler
 * @package Common\Services\ExceptionHandler
 */
class ExceptionHandler
{
    /**
     * @param \Exception $exception
     * @param $code
     * @return JsonResponse
     */
    public function createErrorResponse(\Exception $exception, $code)
    {
        $response = ['message' => $exception->getMessage(), 'status' => 'error'];
        return new JsonResponse($response, $code, ['Content-Type' => 'application/json']);
    }
}
