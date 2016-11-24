<?php

class BushtaxiDao
{
    private $data = [];

    const FILE = '/tmp/votes.json';

    function __construct($bushtaxi, $log)
    {
        $this->bushtaxi = $bushtaxi;
        $this->log = $log;
    }

    function save(Vote $vote)
    {
        $this->log->debug("Send message vote.casted to bushtaxi");
        $this->bushtaxi->getLink('bushtaxi')->send(
            'vote.casted',
            \ZMQ::MODE_SNDMORE
        );
        $this->log->debug("Send vote object to bushtaxi");
        $this->bushtaxi->getLink('bushtaxi')->send(
            json_encode($vote->jsonSerialize())
        );

        $this->log->debug("Done");

        $this->_writeToDisk(
            array_merge(
                $this->getAll(),
                [$vote->id => $vote->jsonSerialize()]
            )
        );

    }

    function getAll()
    {
        if (file_exists(self::FILE)) {
            return json_decode(file_get_contents(self::FILE), true);
        }
        return [];
    }

    private function _writeToDisk($data)
    {
        file_put_contents(
            self::FILE,
            json_encode($data)
        );
    }

}

