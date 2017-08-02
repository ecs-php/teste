<?php

namespace BookStore\Factory;

class ModelFactory extends \BookStore\Models\Model {

    public function create($class_name) {
        $class_res = "\\BookStore\\Models\\$class_name";
        if (!class_exists($class_res)) {
            throw new \Exception("Classe ($class_res) não encontrada", 500);
        }
        return new $class_res($this->dbal);
    }

}
