<?php

//Request::setTrustedProxies(array('127.0.0.1'));
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app) {
    $response = $app->json(array_values($app['dao']->getAll()));
    return $response;
});

$app->post('/', function(Request $request) use ($app) {
    $vote = new Vote(
        json_decode($request->getContent(), true)
    );
    $vote->id =substr(md5(uniqid()), 0, 7);
    $app['dao']->save($vote);
    return $app->json($vote);
});

$app->delete('/{id}', function(Request $request) use ($app) {
    return $app->json(
        $app['dao']->delete($request->get('id'))
    );
});
