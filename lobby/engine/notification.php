<?php

class Notification {

    public function get() {
        global $engine;

        return [
            "name" => "Collection:Notification:",
            "data" => [
                "operation" => 1,
                "cache" => [],
            ]
        ];
    }

}
