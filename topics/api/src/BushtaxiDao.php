<?php

class BushtaxiDao
{
    private $data = [];

    function __construct($bushtaxi)
    {
        $this->bushtaxi = $bushtaxi;
    }

    function save(Meetup $meetup)
    {
        $this->bushtaxi->getLink('api')->send(
            'meetup.saved',
            \ZMQ::MODE_SNDMORE
        );
        $this->bushtaxi->getLink('api')->send(
            json_encode($meetup->jsonSerialize())
        )
    }

    function get($id)
    {
        return $this->getAll()[$id];
    }

    function delete($id)
    {
        $data = $this->getAll();
        unset($data[$id]);
        $this->_writeToDisk($data);
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

