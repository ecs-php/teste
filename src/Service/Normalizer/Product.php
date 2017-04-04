<?php

namespace Service\Normalizer;

class Product extends Entity
{
    public function referenceConfiguration()
    {
        $callbacks = [
            'createdAt' => function (\DateTime $dateTime) {
                return $dateTime ? $dateTime->format('Y-m-d H:i:s') : null;
            },
            'updatedAt' => function (\DateTime $dateTime) {
                return $dateTime ? $dateTime->format('Y-m-d H:i:s') : null;
            }
        ];
        $this->setCallbacks($callbacks);
    }
}
