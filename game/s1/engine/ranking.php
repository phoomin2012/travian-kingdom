<?php

class Ranking {

    public function getWorldStats() {
        global $engine;
        $r = array(
            "players" => array(
                "registered" => query("SELECT * FROM `".$engine->server->prefix."user`")->rowCount(),
                "active" => 0,
                "online" => 0,
            ),
            "kingdoms" => array(
                "kings" => 0,
                "dukes" => query("SELECT * FROM `".$engine->server->prefix."user`")->rowCount(),
                "governors" => 0,
            ),
            "tribes" => array(
                "1" => query("SELECT * FROM `".$engine->server->prefix."user` WHERE `tribe`=?",array(1))->rowCount(),
                "2" => query("SELECT * FROM `".$engine->server->prefix."user` WHERE `tribe`=?",array(2))->rowCount(),
                "3" => query("SELECT * FROM `".$engine->server->prefix."user` WHERE `tribe`=?",array(3))->rowCount(),
            ),
            "world" => array(
                "startTime" => time(),
                "speed" => $engine->server->speed_world,
                "speedTroops" => $engine->server->speed_unit,
            ),
            "troops" => array(
                "1" => array(
                    "1" => 55112,
                    "2" => 24939,
                    "3" => 17640,
                    "4" => 10051,
                    "5" => 9498,
                    "6" => 957,
                    "7" => 107,
                    "8" => 75,
                    "9" => 0,
                    "10" => 98
                ),
                "2" => array(
                    "1" => 76161,
                    "2" => 16327,
                    "3" => 6907,
                    "4" => 5962,
                    "5" => 3865,
                    "6" => 535,
                    "7" => 150,
                    "8" => 25,
                    "9" => 0,
                    "10" => 69
                ),
                "3" => array(
                    "1" => 79103,
                    "2" => 32470,
                    "3" => 8430,
                    "4" => 13363,
                    "5" => 2629,
                    "6" => 808,
                    "7" => 89,
                    "8" => 1,
                    "9" => 0,
                    "10" => 121
                )
            )
        );
        return $r;
    }
    
    public function getKingdomStats($kid){
        global $engine;
        
        $k = $engine->kingdom->get($kid);
        $kr = query("SELECT * FROM `{$engine->server->prefix}kingdom` WHERE `id`=?;", [$kid])->fetch(PDO::FETCH_ASSOC);
        
        $us = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `kingdom`=?;", [$kid])->fetchAll(PDO::FETCH_ASSOC);
        $vc = 0;
        foreach ($us as $u) {
            $v = $engine->village->getAll($u['uid']);
            $vc += count($v);
        }
        
        $r = [
            "kingId" => $kid,
            "kingName" => $k['tag'],
            "members" => count($k['members']),
            "rank" => false,
            "treasures" => false,
            "victoryPoints" => $kr['vca'] == 0 ? false : $kr['vca'],
            "villages" => $vc,
            "worldWonderLvl" => false,
        ];
        return $r;
    }

}
