<?php

use Silex\Application;

$app = new Application();
$app['bushtaxi.config'] = json_decode(file_get_contents(__DIR__ . '/../config/bushtaxi.json'), true);

$app['bushtaxi.log'] = function($app) {
    $log = new Monolog\Logger($app['bushtaxi.config']['service']['name']);
    $handler = new Monolog\Handler\StreamHandler(
        'php://stdout',
        Monolog\Logger::DEBUG
    );
    $log->pushHandler($handler);
    return $log;
};
$app['bushtaxi.client'] = function($app) {
    return new Bushtaxi\Client(
        $app['bushtaxi.config'],
        $app['bushtaxi.log']
    );
};
$app['dao'] = function($app) {
    return new BushtaxiDao(
        $app['bushtaxi.client'],
        $app['bushtaxi.log']
    );
};
return $app;
