<?php

namespace Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserListener {



    public function preFlush(User $user) {
       
       $user->updatedTimestamps();
       return $user;
    }

}
