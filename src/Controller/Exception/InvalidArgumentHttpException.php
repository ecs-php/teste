<?php

namespace Controller\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidArgumentHttpException extends HttpException
{
    /**
     * @param string $message  The internal exception message
     * @param int $code The internal exception code
     * @param \Exception $previous The previous exception
     */
    public function __construct(
        string $message = null,
        int $code = Response::HTTP_OK,
        \Exception $previous = null
    ) {
        parent::__construct($code, $message, $previous);
    }
}
