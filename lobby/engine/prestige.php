<?php

class Prestige {

    public function get($uid) {
        global $engine;
        $uid === null ? $uid = $_SESSION['lobby_uid'] : 0;
        
        $r = [
            "name" => "PrestigeDetails:{$uid}",
            "data" => [
                "achievementPrestige" => 3,
                "activeGameWorldsPrestige" => 1,
                "currentLevelPrestigePoints" => 3,
                "finishedGameWorldsPrestige" => 0,
                "globalPrestige" => 3,
                "level" => 1,
                "levelProgressPercentage" => 30,
                "nextLevel" => 2,
                "nextLevelPrestigePoints" => 10,
                "stars" => [
                    "bronze" => 3,
                    "silver" => 2,
                ]
            ]
        ];
        return $r;
    }

}
