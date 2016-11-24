<?php

require 'vendor/autoload.php';

class Runtime extends Bushtaxi\AbstractServerRuntime {
    function __construct($log) {
        $this->log = $log;
    }

    function handle($links)
    {
        $this->log->debug("Listening for event from api");
        $event = $links['api']->recv();
        $this->log->debug("Received message $event");
        $this->log->debug("Listening for payload from api");
        $payload = $links['api']->recv();
        $this->log->debug("Received message $payload");

        $this->log->debug("Publishing event $event");
        $links['subscribers']->send($event, \ZMQ::MODE_SNDMORE);
        $this->log->debug("Sending payload");
        $links['subscribers']->send($payload);

        $this->log->debug("Done");
    }
}

$config = json_decode(file_get_contents(__DIR__ . '/votes.json'), true);
$log = new Monolog\Logger($config['service']['name']);

$bushtaxi = new Bushtaxi\Server(
    $config,
    new Runtime($log),
    $log
);

$bushtaxi->run();
