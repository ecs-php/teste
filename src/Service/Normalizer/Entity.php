<?php

namespace Service\Normalizer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class Entity extends ObjectNormalizer
{
    public function __construct()
    {
        parent::__construct();
        $this->referenceConfiguration();
        $this->setCircularReferenceLimit(0);
        $this->setCircularReferenceHandler(function () {
            return [];
        });
        //$this->setIgnoredAttributes(['field1', 'field2']);
    }

    abstract public function referenceConfiguration();

    /**
     * @param array $collection
     * @return array
     */
    public function normalizeCollection(array $collection): array
    {
        $normalizedEntities = [];
        foreach ($collection as $entity) {
            $normalizedEntity = $this->normalize($entity);
            $normalizedEntities[] = $normalizedEntity;
        }
        return $normalizedEntities;
    }
}
