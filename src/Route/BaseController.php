<?php

$base = $app['controllers_factory'];

$base->get('/', function () { 
    return 'teste';     
});

return $base;
