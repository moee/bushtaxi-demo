<?php

class Dao
{
    private $data = [];

    const FILE = '/tmp/meetups.json';

    function save(Meetup $meetup)
    {
        $this->_writeToDisk(
            array_merge(
                $this->getAll(),
                [
                    $meetup->id => $meetup->jsonSerialize()
                ]
            )
        );
    }

    function get($id)
    {
        return new Meetup($this->getAll()[$id]);
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

