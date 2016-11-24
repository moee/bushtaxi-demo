<?php

require 'vendor/autoload.php';

class Runtime extends Bushtaxi\AbstractServerRuntime {
    function __construct($log) {
        $this->log = $log;
    }

    function handle($links)
    {
        $this->log->debug("Listening for event from votes");
        $event = $links['votes']->recv();
        $this->log->debug("Received event $event");
        $this->log->debug("Listening for payload from votes");
        $payload = $links['votes']->recv();
        $this->log->debug("Received $payload");

        $vote = json_decode($payload, true);

        $this->log->debug("Patching topics api");
        $client = new GuzzleHttp\Client(['base_uri' => 'http://topics_api/']);
        $client->patch(
            "/{$vote['topic_id']}",
            [
                'json' => [
                    'votes' => $vote['vote'],
                ]
            ]
        );
        $this->log->debug("Done");
    }
}

$config = json_decode(file_get_contents(__DIR__ . '/topics.json'), true);
$log = new Monolog\Logger($config['service']['name']);

$bushtaxi = new Bushtaxi\Server(
    $config,
    new Runtime($log),
    $log
);

$bushtaxi->run();
