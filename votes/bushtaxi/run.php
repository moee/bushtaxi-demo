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
        $event = $links['api']->recv();
        $this->log->debug("Listening for payload");
        $payload = $links['api']->recv();

        $this->log->debug("Publishing event");
        $links['subscribers']->send($event, \ZMQ::MODE_SNDMORE);
        $links['subscribers']->send($payload);
    }

    function shutdown()
    {

    }
}

$config = json_decode(file_get_contents(__DIR__ . '/votes.json'), true);
$log = new Monolog\Logger($config['service']['name']);

$bushtaxi = new Bushtaxi\Server(
    $config,
    $log,
    new Runtime($log)
);

$bushtaxi->run();
