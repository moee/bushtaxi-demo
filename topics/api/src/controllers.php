<?php

//Request::setTrustedProxies(array('127.0.0.1'));
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app) {
    $response = $app->json(array_values($app['dao']->getAll()));
    return $response;
});

$app->post('/', function(Request $request) use ($app) {
    $meetup = new Meetup(
        json_decode($request->getContent(), true)
    );
    $meetup->id =substr(md5(uniqid()), 0, 7);
    $app['dao']->save($meetup);
    return $app->json(true);
});

$app->delete('/{id}', function(Request $request) use ($app) {
    return $app->json(
        $app['dao']->delete($request->get('id'))
    );
});

$app->get('/{id}', function(Request $request) use ($app) {
    return $app->json(
        $app['dao']->get($request->get('id'))
    );
});

$app->patch('/{id}', function(Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $topic = $app['dao']->get($request->get('id'));
    $topic->total += $data['votes'];
    $app['dao']->save($topic);
    return $topic->total;
});
