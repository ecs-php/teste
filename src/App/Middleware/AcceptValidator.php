<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AcceptValidator
{
    public function __invoke(Request $request)
    {
        $headers = $request->headers->get('accept', null, false);

        $isValid = in_array('*/*', $headers) || in_array('application/json', $headers);

        if (!$isValid) {
            return new Response(null, Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
