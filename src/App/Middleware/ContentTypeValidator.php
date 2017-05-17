<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ContentTypeValidator
{
    public function __invoke(Request $request)
    {
        $headers = $request->headers->get('content-type', null, false);

        $isValid = count($headers) == 1 && in_array('application/json', $headers);

        if (!$isValid) {
            return new Response(null, Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
