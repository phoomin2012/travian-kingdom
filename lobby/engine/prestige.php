<?php

class Prestige {

    public function get() {
        global $engine;

        return [
            "name" => "PrestigeDetails:".$_SESSION['lobby_uid'],
            "data" => [
                "globalPrestige" => 409,
                "level" => 6,
                "stars" => [
                    "silver" => 3
                ],
                "finishedGameWorldsPrestige" => "174",
                "activeGameWorldsPrestige" => "55",
                "nextLevelPrestigePoints" => 500,
                "currentLevelPrestigePoints" => 400
            ]
        ];
    }

}
