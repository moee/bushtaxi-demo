<?php

require 'vendor/autoload.php';

class Runtime implements Bushtaxi\Runtime {
    function __construct($log) {
        $this->log = $log;
    }
    function init($links)
    {

    }

    function isRunning()
    {
        return true;
    }

    function handle($links)
    {
        $this->log->debug("Listening for event");
        $event = $links['votes']->recv();
        $this->log->debug("Listening for payload");
        $payload = $links['votes']->recv();

        $this->log->debug("HOORAY $payload");

        $vote = json_decode($payload, true);

        $client = new GuzzleHttp\Client(['base_uri' => 'http://topics_api/']);
        $client->patch(
            "/{$vote['topic_id']}",
            [
                'json' => [
                    'votes' => $vote['vote'],
                ]
            ]
        );


    }

    function shutdown()
    {

    }
}

$config = json_decode(file_get_contents(__DIR__ . '/topics.json'), true);
$log = new Monolog\Logger($config['service']['name']);

$bushtaxi = new Bushtaxi\Server(
    $config,
    $log,
    new Runtime($log)
);

$bushtaxi->run();
