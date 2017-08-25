<?php

class Database {

    function listServer($full = false) {
        global $engine;
        $sql = "SELECT * FROM `global_server_data`";
        $s = query($sql)->fetchAll();
        $r = array();
        for ($i = 0; $i < count($s); $i++) {
            $r[$i] = [
                "consumersId" => $s[$i]['sid'],
                "identifier" => "travian-ks-en-" . $s[$i]['tag'],
                "country" => "en",
                "region" => "international",
                "status" => 2,
                "gameId" => 30,
                "applicationId" => "travian-ks",
                "applicationCountryId" => "en",
                "applicationInstanceId" => $s[$i]['tag'],
                "worldName" => $s[$i]['name'],
                "worldStartTime" => $s[$i]['start'],
                "playersRegistered" => query("SELECT * FROM `" . $s[$i]['prefix'] . "user`")->rowCount(),
                "playersActive" => 0,
                "playersOnline" => 0,
                "worldCapacity" => 0,
                "recommended" => (int) $s[$i]['recommended'],
                "blacklisted" => 0,
                "baseUrl" => "",
                "daysSinceStart" => round((time() - $s[$i]['start']) / 86400),
                "speedGame" => $s[$i]['speed_world'],
                "speedTroops" => $s[$i]['speed_unit'],
                "specialRules" => ["nightPeace"], //"cropDiet"
                "canTransferMoney" => 1,
                "tribes" => [
                    "1" => query("SELECT * FROM `" . $s[$i]['prefix'] . "user` WHERE `tribe`=?",[1])->rowCount(),
                    "2" => query("SELECT * FROM `" . $s[$i]['prefix'] . "user` WHERE `tribe`=?",[2])->rowCount(),
                    "3" => query("SELECT * FROM `" . $s[$i]['prefix'] . "user` WHERE `tribe`=?",[3])->rowCount(),
                ],
                "wwIsActivated" => 0,
                "currentWWLevel" => 0,
                "maxWWLevel" => 100,
            ];
        }
        return $r;
    }

    public function msid($email = "abcdefghijklmnopqrstuvwxyz") {
        $token = rand(0, 1000);
        $token = $token . $email . rand(1000, 10000);
        $token = hash('adler32', $token);
        $token = time() . $token;
        $token = hash('crc32b', $token);
        $token = $token . hash('crc32', $token);

        $q = query("SELECT * FROM `global_msid` WHERE `email`=? AND `ip`=?", array($email, $_SERVER['REMOTE_ADDR']));
        if ($q->rowCount() == 1) {
            $t = $q->fetch();
            $token = $t['token'];
        } else {
            query("DELETE FROM `global_msid` WHERE `email`=? AND `ip`=?", array($email, $_SERVER['REMOTE_ADDR']));
            query("INSERT INTO `global_msid` (`token`,`email`,`ip`) VALUES (?,?,?);", array($token, $email, $_SERVER['REMOTE_ADDR']));
        }
        return $token;
    }

    public function getServerInfo($world) {
        global $engine;
        return query("SELECT * FROM `global_server_data` WHERE `sid`=?;", array($world))->fetch();
    }

}
