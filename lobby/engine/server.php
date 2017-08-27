<?php

class Server {

    function listServer($full = false) {
        global $engine;
        $ss = query("SELECT * FROM `global_server_data`")->fetchAll(PDO::FETCH_ASSOC);
        $r = [];
        foreach ($ss as $s) {
            $sdq = query("SELECT * FROM `{$s['prefix']}user` WHERE `email`=?;", [$_SESSION['lobby_email']]);
            if ($sdq->rowCount() == 0) {
                $r[] = $this->getInfo($s);
            }
        }
        return $r;
    }

    public function getInfo($world) {
        global $engine;

        if (!is_array($world)) {
            $world = query("SELECT * FROM `global_server_data` WHERE `sid`=?;", [$world])->fetch(PDO::FETCH_ASSOC);
        }
        $r = [
            "consumersId" => $world['sid'],
            "identifier" => "travian-ks-en-" . $world['tag'],
            "country" => "en",
            "region" => "international",
            "status" => 2,
            "gameId" => 30,
            "applicationId" => "travian-ks",
            "applicationCountryId" => "en",
            "applicationInstanceId" => $world['tag'],
            "worldName" => $world['name'],
            "worldStartTime" => $world['start'],
            "playersRegistered" => query("SELECT * FROM `" . $world['prefix'] . "user`")->rowCount(),
            "playersActive" => 0,
            "playersOnline" => 0,
            "worldCapacity" => 0,
            "recommended" => (int) $world['recommended'],
            "blacklisted" => 0,
            "baseUrl" => "",
            "daysSinceStart" => round((time() - $world['start']) / 86400),
            "speedGame" => 1,//$world['speed_world'],
            "speedTroops" => 1,//$world['speed_unit'],
            "specialRules" => ["none"], //"none","cropDiet","nightPeace"
            "canTransferMoney" => 1,
            "tribes" => [
                "1" => query("SELECT * FROM `" . $world['prefix'] . "user` WHERE `tribe`=?", [1])->rowCount(),
                "2" => query("SELECT * FROM `" . $world['prefix'] . "user` WHERE `tribe`=?", [2])->rowCount(),
                "3" => query("SELECT * FROM `" . $world['prefix'] . "user` WHERE `tribe`=?", [3])->rowCount(),
            ],
            "wwIsActivated" => 0,
            "currentWWLevel" => 0,
            "maxWWLevel" => 100,
        ];
        return $r;
    }

    public function getServerInfo($world) {
        global $engine;
        return query("SELECT * FROM `global_server_data` WHERE `sid`=?;", array($world))->fetch(PDO::FETCH_ASSOC);
    }

    public function sittler($world) {
        global $engine;
    }

}
