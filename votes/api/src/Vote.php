<?php

class Vote implements JsonSerializable {
    public $id, $topic_id, $vote;

    public function __construct($data)
    {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'topic_id' => $this->topic_id,
            'vote' => $this->vote
        ];
    }
}

