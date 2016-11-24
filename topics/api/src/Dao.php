<?php

class Dao
{
    private $data = [];

    const FILE = '/tmp/topics.json';

    function save(Topic $topic)
    {
        if (!isset($topic->id)) {
            $topic->id =substr(md5(uniqid()), 0, 7);
        }

        $this->_writeToDisk(
            array_merge(
                $this->getAll(),
                ["i" . strval($topic->id) => $topic->jsonSerialize()]
            )
        );

        return $topic;
    }

    function get($id)
    {
        return new Topic($this->getAll()["i" . $id]);
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

