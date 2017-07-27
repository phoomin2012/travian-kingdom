<?php

class Technology {

    public function getTech($wid, $unit = null) {
        global $engine;

        $t = query("SELECT * FROM `" . $engine->server->prefix . "tdata` WHERE `wid`=?", array($wid))->fetch();
        if ($unit === null) {
            return $t;
        } else {
            $unit = $unit % 10;
            if ($unit == 10 || $unit == 0) {
                return 0;
            } else {
                return $t['t' . $unit];
            }
        }
    }

    public function getResearch($wid) {
        global $engine;

        $queue = query("SELECT * FROM `" . $engine->server->prefix . "tqueue` WHERE `wid`=?", array($wid))->fetchAll();
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?", array($wid))->fetch();
        $p = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?", array($v['owner']))->fetch();
        $t = $this->getTech($wid);
        $upFull = false;
        $resFull = false;
        for ($i = 0; $i < count($queue); $i++) {
            if ($t['t' . ($queue[$i]['type'] % 10)] == -2) {
                $resFull = true;
            } else {
                $upFull = true;
            }
        }

        $r = array(
            "name" => "Research:" . $wid,
            "data" => array(
                "upgradeQueueFull" => $upFull,
                "researchQueueFull" => $resFull,
                "units" => array(),
            )
        );
        ($p['tribe'] == 0) ? $p['tribe'] = 1 : '';
        for ($i = 1; $i < 10; $i++) {
            array_push($r['data']['units'], $this->buildUnitResearchData($i + (($p['tribe'] - 1) * 10), $wid));
        }

        return $r;
    }

    public function Research($wid, $type) {
        global $engine;
        $t = $this->getTech($wid, $type);
        if ($t >= 0) {
            $res = ImproveData::get($type, $t + 1);
            $b = 13;
        } else {
            $res = ReseachData::get($type);
            $b = 22;
        }
        $uid = $engine->account->getByVillage($wid, 'uid');
        $engine->auto->emitEvent($uid, array(
            "name" => "flashNotification",
            "data" => "54",
        ));
        $start = time();
        $end = $start + ($res['time'] / $engine->server->speed_world);
        query("INSERT INTO `" . $engine->server->prefix . "tqueue` (`wid`,`type`,`building`,`start`,`end`) VALUES (?,?,?,?,?)", array($wid, $type, $b, $start, $end));
        $engine->auto->procRes($wid);
        query("UPDATE `" . $engine->server->prefix . "village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($res['wood'], $res['clay'], $res['iron'], $res['crop'], $wid));
    }

    public function getResearchQueue($wid) {
        global $engine;

        $tq = query("SELECT * FROM `" . $engine->server->prefix . "tqueue` WHERE `wid`=?", array($wid))->fetchAll();
        $t = query("SELECT * FROM `" . $engine->server->prefix . "tdata` WHERE `wid`=?", array($wid))->fetch();

        $r = array(
            "name" => "UnitResearchQueue:" . $wid,
            "data" => array(
                "villageId" => $wid,
                "buildingTypes" => array(
                    "22" => array(),
                    "13" => array(),
                ),
            )
        );
        $queue = array(22 => false, 13 => false);
        for ($i = 0; $i < count($tq); $i++) {
            if ($t['t' . ($tq[$i]['type'] % 10)] == -2) {
                array_push($r['data']['buildingTypes']['22'], array(
                    "unitType" => $tq[$i]['type'],
                    "researchLevel" => "0",
                    "startTime" => $tq[$i]['start'],
                    "finished" => $tq[$i]['end'],
                    "pause" => (!$queue[22]) ? (-1 && $queue[22] = true) : 1,
                ));
            } else {
                array_push($r['data']['buildingTypes']['13'], array(
                    "unitType" => $tq[$i]['type'],
                    "researchLevel" => "0",
                    "startTime" => $tq[$i]['start'],
                    "finished" => $tq[$i]['end'],
                    "pause" => (!$queue[13]) ? (-1 && $queue[13] = true) : 1,
                ));
            }
        }


        return $r;
    }

    private function ResReachRequire($type, $level, $wid) {
        global $engine;

        $r = array(
            "buildingType" => $type,
            "currentLevel" => $engine->building->getTypeLevel($wid, $type),
            "requiredLevel" => $level,
        );
        if ($r['currentLevel'] >= $r['requiredLevel']) {
            $r['valid'] = true;
        } else {
            $r['valid'] = false;
        }
        return $r;
    }

    private function buildUnitResearchData($type, $wid) {
        global $engine;

        $t = $this->getTech($wid, $type);
        if ($t >= 0) {
            $res = ImproveData::get($type, $t + 1);
        } else {
            $res = ReseachData::get($type);
        }

        $canRes = false;
        $canUp = true;
        $require = array();
        if ($type == 2 || $type == 12 || $type == 22) {
            $r2 = $this->ResReachRequire(22, 3, $wid);
            $r1 = $this->ResReachRequire(13, 1, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 3 || $type == 13) {
            $r2 = $this->ResReachRequire(22, 5, $wid);
            $r1 = $this->ResReachRequire(19, 5, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 4 || $type == 14 || $type == 23) {
            $r1 = $this->ResReachRequire(22, 5, $wid);
            $r2 = $this->ResReachRequire(20, 1, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 24) {
            $r1 = $this->ResReachRequire(22, 5, $wid);
            $r2 = $this->ResReachRequire(20, 3, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 5 || $type == 15 || $type == 25) {
            $r1 = $this->ResReachRequire(22, 10, $wid);
            $r2 = $this->ResReachRequire(20, 5, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 6 || $type == 16 || $type == 26) {
            $r1 = $this->ResReachRequire(22, 15, $wid);
            $r2 = $this->ResReachRequire(20, 10, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 7 || $type == 17 || $type == 27) {
            $r1 = $this->ResReachRequire(22, 10, $wid);
            $r2 = $this->ResReachRequire(21, 1, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }if ($type == 8 || $type == 18 || $type == 28) {
            $r1 = $this->ResReachRequire(22, 15, $wid);
            $r2 = $this->ResReachRequire(21, 10, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }
        if ($type == 9 || $type == 19 || $type == 29) {
            $r1 = $this->ResReachRequire(22, 20, $wid);
            $r2 = $this->ResReachRequire(16, 10, $wid);
            array_push($require, $r1);
            array_push($require, $r2);
            if ($r1['valid'] == true && $r2['valid'] == true) {
                $canRes = true;
            }
            $canUp = ($t >= 0) ? true : false;
        }

        if ($t >= 0) {
            $canRes = false;
        }

        $blacksmith = $engine->building->getTypeLevel($wid, 13);
        if ($blacksmith <= $t) {
            $canUp = false;
        }

        $queue = query("SELECT * FROM `" . $engine->server->prefix . "tqueue` WHERE `wid`=? AND `type`=?", array($wid, $type))->rowCount();

        $cs = [
            "attack" => round(UnitData::get($type, 'atk') * (1 + (0.015 * $t)) * 10) / 10,
            "defence" => round(UnitData::get($type, 'di') * (1 + (0.015 * $t)) * 10) / 10,
            "defenceCavalry" => round(UnitData::get($type, 'dc') * (1 + (0.015 * $t)) * 10) / 10
        ];
        $rs = [];
        for ($l = 1; $l <= 3; $l++) {
            array_push($rs, [
                "level" => $t + $l,
                "attack" => round(UnitData::get($type, 'atk') * (1 + (0.015 * ($t + $l))) * 10) / 10,
                "defence" => round(UnitData::get($type, 'di') * (1 + (0.015 * ($t + $l))) * 10) / 10,
                "defenceCavalry" => round(UnitData::get($type, 'dc') * (1 + (0.015 * ($t + $l))) * 10) / 10
            ]);
        }


        $r = array(
            "unitType" => $type,
            "unitLevel" => $t,
            "costs" => array(
                "1" => $res['wood'],
                "2" => $res['clay'],
                "3" => $res['iron'],
                "4" => $res['crop']
            ),
            "time" => $res['time'] / $engine->server->speed_world,
            "canResearch" => $canRes,
            "canUpgrade" => $canUp,
            "unitsInUpgrade" => ($queue > 0) ? 1 : 0,
            "required" => ($canUp) ? array() : $require,
            "maxLevel" => 20,
            "currentStrength" => $cs,
            "researchStrength" => $rs
        );

        return $r;
    }

    public function getPower($wid, $type, $field = null) {
        global $engine;

        if (is_array($wid))
            $t = $wid[0];
        else
            $t = $this->getTech($wid, $type);
        $t < 0 ? $t = 0 : '';

        $cs = [
            "attack" => round(UnitData::get($type, 'atk') * (1 + (0.015 * $t)) * 10) / 10,
            "atk" => round(UnitData::get($type, 'atk') * (1 + (0.015 * $t)) * 10) / 10,
            "defence" => round(UnitData::get($type, 'di') * (1 + (0.015 * $t)) * 10) / 10,
            "di" => round(UnitData::get($type, 'di') * (1 + (0.015 * $t)) * 10) / 10,
            "defenceCavalry" => round(UnitData::get($type, 'dc') * (1 + (0.015 * $t)) * 10) / 10,
            "dc" => round(UnitData::get($type, 'dc') * (1 + (0.015 * $t)) * 10) / 10,
        ];
        return $field === null ? $cs : $cs[$field];
    }

}
