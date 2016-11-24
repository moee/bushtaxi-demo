<?php

class Topic implements JsonSerializable {
    public $id, $title, $location, $total = 0;

    public function __construct($data)
    {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'speaker' => $this->speaker,
            'total' => $this->total
        ];
    }
}

