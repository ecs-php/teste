<?php

namespace BookStore\Services;

class Authentication {

    function signIn($login, $pass) {
        if ($login == 'admin' && $pass == '123456') {
            return true;
        }
        return false;
    }

}
