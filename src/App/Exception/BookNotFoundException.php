<?php

namespace App\Exception;

class BookNotFoundException extends AppException
{
    public function __construct($id, $code = 404, \Exception $previous = null)
    {
        parent::__construct(sprintf('Book %d does not exist', $id), $code, $previous);
    }

}