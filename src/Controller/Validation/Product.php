<?php

namespace Controller\Validation;

use Controller\Exception\InvalidArgumentHttpException;

class Product implements ValidationInterface
{
    /**
     * @param \stdClass $data
     */
    public function validate(\stdClass $data)
    {
        if (!$data->name) {
            throw new InvalidArgumentHttpException('Name must be informed');
        }
        if (!$data->description) {
            throw new InvalidArgumentHttpException('Descrption must be informed');
        }
        if (!$data->price) {
            throw new InvalidArgumentHttpException('Price must be informed');
        }
        if (!$data->weight) {
            throw new InvalidArgumentHttpException('Weight must be informed');
        }
        if (!$data->active) {
            throw new InvalidArgumentHttpException('Active must be informed');
        }
        if (strlen($data->name) > 100) {
            throw new InvalidArgumentHttpException('Name cannot be longer than 100 characters');
        }
        if (strlen($data->description) > 255) {
            throw new InvalidArgumentHttpException('Description cannot be longer than 100 characters');
        }
        if ($data->price < 0) {
            throw new InvalidArgumentHttpException('Price cannot be a negative value');
        }
        if ($data->weight < 0) {
            throw new InvalidArgumentHttpException('Weight cannot be a negative value');
        }
        if (!is_bool($data->active)) {
            throw new InvalidArgumentHttpException('Active must be a boolean value');
        }
    }
}
