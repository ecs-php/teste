<?php
/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:44
 */

foreach (glob(__DIR__ . "/routing/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/services/*.php") as $filename) {
    require_once $filename;
}
