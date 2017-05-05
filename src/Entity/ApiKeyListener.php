<?php

namespace Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class ApiKeyListener {

    public function preFlush(ApiKey $apikey) {
        $apikey->createKey();
        $apikey->updatedTimestamps();
        return $apikey;
    }

}
