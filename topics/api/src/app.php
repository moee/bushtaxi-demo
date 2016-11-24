<?php

use Silex\Application;

$app = new Application();
$app['bushtaxi'] = function() {
    return new Bushtaxi\Server();
};
$app['dao'] = function() {
    return new Dao();
};
return $app;
