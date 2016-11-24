<?php

class Dao
{
    private $data = [];

    const FILE = '/tmp/votes.json';

    function save(Vote $vote)
    {
        $this->_writeToDisk(
            array_merge(
                $this->getAll(),
                [
                    $vote->id => $vote->jsonSerialize()
                ]
            )
        );
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

