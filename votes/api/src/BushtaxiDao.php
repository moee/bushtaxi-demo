<?php

class BushtaxiDao
{
    private $data = [];

    const FILE = '/tmp/votes.json';

    function __construct($bushtaxi)
    {
        $this->bushtaxi = $bushtaxi;
    }

    function save(Vote $vote)
    {
        $this->bushtaxi->getLink('api')->send(
            'vote.casted',
            \ZMQ::MODE_SNDMORE
        );
        $this->bushtaxi->getLink('api')->send(
            json_encode($vote->jsonSerialize())
        );

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

