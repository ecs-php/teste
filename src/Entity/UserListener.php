<?php

namespace Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserListener {

    public function preFlush(User $user) {
        $password = $user->getPassword();
        if (strlen($password) < 60) {
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }
        $user->updatedTimestamps();
        return $user;
    }

}
