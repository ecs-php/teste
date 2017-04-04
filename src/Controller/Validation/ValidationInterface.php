<?php

namespace Controller\Validation;

interface ValidationInterface
{
    public function validate(\stdClass $data);
}
