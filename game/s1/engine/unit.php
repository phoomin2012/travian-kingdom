<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class Unit {

    var $barrack = array(1, 2, 3, 11, 12, 13, 21, 22);
    var $stable = array(4, 5, 6, 14, 15, 16, 23, 24, 25, 26);
    var $workshop = array(7, 8, 17, 18, 27, 28);
    var $residence_palase = array(9, 10, 19, 20, 29, 30);

    public function getTraining($id) {
        global $engine;

        $r = array(
            'name' => 'UnitQueue:' . $id,
            'data' => array(
                'villageId' => $id,
                'buildingTypes' => array(
                    "19" => array(),
                    "20" => array(),
                    "21" => array(),
                    "25" => array(),
                    "26" => array(),
                ),
            ),
        );

        $tq = query("SELECT * FROM `" . $engine->server->prefix . "train` WHERE `wid`=?", array($id))->fetchAll();

        for ($i = 0; $i < count($tq); $i++) {

            $all_unit = 0;
            $last_time = $tq[$i]['start'];
            $duration = 0;
            $tqsub = query("SELECT * FROM `" . $engine->server->prefix . "train_queue` WHERE `tid`=?", array($tq[$i]['id']))->fetchAll();
            foreach ($tqsub as $value) {
                if ($duration == 0) {
                    $duration = $value['duration'];
                }
                $all_unit += $value['amount'];
                $last_time += ($value['amount'] * $value['duration']);
            }

            if (in_array($tq[$i]['type'], $this->barrack)) {
                array_push($r['data']['buildingTypes']['19'], array(
                    "unitType" => $tq[$i]['type'],
                    "count" => $all_unit,
                    "durationPerUnit" => $duration,
                    "timeFinishedNext" => $tq[$i]['next'],
                    "timeFinishedLast" => $last_time,
                ));
            } elseif (in_array($tq[$i]['type'], $this->stable)) {
                array_push($r['data']['buildingTypes']['20'], array(
                    "unitType" => $tq[$i]['type'],
                    "count" => $all_unit,
                    "durationPerUnit" => $duration,
                    "timeFinishedNext" => $tq[$i]['next'],
                    "timeFinishedLast" => $last_time,
                ));
            } elseif (in_array($tq[$i]['type'], $this->workshop)) {
                array_push($r['data']['buildingTypes']['21'], array(
                    "unitType" => $tq[$i]['type'],
                    "count" => $all_unit,
                    "durationPerUnit" => $duration,
                    "timeFinishedNext" => $tq[$i]['next'],
                    "timeFinishedLast" => $last_time,
                ));
            } elseif (in_array($tq[$i]['type'], $this->residence_palase)) {
                $residence = $engine->building->getTypeLevel($tq[$i]['wid'], 25);
                $palase = $engine->building->getTypeLevel($tq[$i]['wid'], 26);
                if ($residence > 0) {
                    array_push($r['data']['buildingTypes']['25'], array(
                        "unitType" => $tq[$i]['type'],
                        "count" => $all_unit,
                        "durationPerUnit" => $duration,
                        "timeFinishedNext" => $tq[$i]['next'],
                        "timeFinishedLast" => $last_time,
                    ));
                } elseif ($palase > 0) {
                    array_push($r['data']['buildingTypes']['26'], array(
                        "unitType" => $tq[$i]['type'],
                        "count" => $all_unit,
                        "durationPerUnit" => $duration,
                        "timeFinishedNext" => $tq[$i]['next'],
                        "timeFinishedLast" => $last_time,
                    ));
                }
            }
        }

        return $r;
    }

    public function training($wid, $type, $amount = 0) {
        global $engine;

        $uid = $engine->account->getByVillage($wid, 'uid');
        $engine->auto->emitEvent($uid, array(
            "name" => "flashNotification",
            "data" => "53",
        ));

        $res = UnitData::get($type);
        if (in_array($type, $this->barrack)) {
            $btype = 19;
        } elseif (in_array($type, $this->stable)) {
            $btype = 20;
        } elseif (in_array($type, $this->workshop)) {
            $btype = 21;
        } elseif (in_array($type, $this->residence_palase)) {
            $residence = $engine->building->getTypeLevel($wid, 25);
            $palase = $engine->building->getTypeLevel($wid, 26);
            if ($residence > 0) {
                $btype = 25;
            } elseif ($palase > 0) {
                $btype = 26;
            }
        }
        if ($type == 9 || $type == 19 || $type == 29) {
            $engine->village->setVillageField($wid, "settler_used", $engine->village->getVillageField($wid, "settler_used") + 3 * $amount);
        } elseif ($type == 10 || $type == 20 || $type == 30) {
            $engine->village->setVillageField($wid, "settler_used", $engine->village->getVillageField($wid, "settler_used") + 1 * $amount);
        }

        $duration = ($res['time'] * ($engine->building->BuildingEffect($btype, $engine->building->getTypeLevel($wid, $btype)) / 100)) / $engine->server->speed_world;
        $start = time();
        $next = $start + $duration;

        $qt = query("SELECT * FROM `" . $engine->server->prefix . "train` WHERE `wid`=? AND `type`=?", array($wid, $type));
        if ($qt->rowCount() > 0) {
            $last = $qt->fetch()['id'];
        } else {
            query("INSERT INTO `" . $engine->server->prefix . "train` (`wid`,`type`,`duration`,`start`,`next`) VALUES (?,?,?,?,?)", array($wid, $type, $duration, $start, $next));
            $last = $engine->sql->lastInsertId();
        }
        $tsub = query("SELECT * FROM `" . $engine->server->prefix . "train_queue` WHERE `tid`=? AND `duration`=?", array($last, $duration));
        if ($tsub->rowCount() > 0) {
            query("UPDATE `" . $engine->server->prefix . "train_queue` SET `amount`=`amount`+? WHERE `tid`=? AND `duration`=?", array($amount, $last, $duration));
        } else {
            query("INSERT INTO `" . $engine->server->prefix . "train_queue` (`tid`,`amount`,`duration`) VALUES (?,?,?)", array($last, $amount, $duration));
        }
        $res = UnitData::get($type);
        $res['wood'] = $res['wood'] * $amount;
        $res['clay'] = $res['clay'] * $amount;
        $res['iron'] = $res['iron'] * $amount;
        $res['crop'] = $res['crop'] * $amount;
        $engine->auto->procRes($wid);
        query("UPDATE `" . $engine->server->prefix . "village` SET `wood`=`wood`-?,`clay`=`clay`-?,`iron`=`iron`-?,`crop`=`crop`-? WHERE `wid`=?", array($res['wood'], $res['clay'], $res['iron'], $res['crop'], $wid));

        $p = $engine->account->getById($_SESSION[$engine->server->prefix . 'uid']);
        if ($p['tutorial'] == 9) {
            $engine->account->edit('tutorial', 10, $p['uid']);
            $engine->auto->emitCache($p['uid'], $engine->quest->get($p['uid']));
        }
    }

    public function getVillageSupply($wid) {
        global $engine;
        $u = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `wid`=?;", array($wid))->fetch();
        $p = $engine->account->getByVillage($wid);
        $supply = 0;
        for ($i = 1; $i <= 10; $i++) {
            $supply += $u['u' . $i] * UnitData::get($i + (($p['tribe'] - 1) * 10), 'pop');
        }
        return $supply;
    }

    public function getUnit($id, $head = true) {
        global $engine;
        $u = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `id`=?;", array($id))->fetch();
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($u['wid']))->fetch();
        $p = $engine->account->getByVillage($u['wid']);

        $supply = 0;
        for ($i = 1; $i <= 10; $i++) {
            $supply += $u['u' . $i] * UnitData::get($i + (($p['tribe'] - 1) * 10), 'pop');
        }

        $return = array(
            "name" => "Troops:" . $u['id'],
            "data" => array(
                "capacity" => 715,
                "filter" => "",
                "playerId" => $p['uid'],
                "playerIdLocation" => "0",
                "playerName" => $p['username'],
                "playerNameLocation" => "",
                "status" => "",
                "supplyTroops" => $supply,
                "tribeId" => $p['tribe'],
                "troopId" => $u['id'],
                "units" => array(
                    1 => $u['u1'],
                    2 => $u['u2'],
                    3 => $u['u3'],
                    4 => $u['u4'],
                    5 => $u['u5'],
                    6 => $u['u6'],
                    7 => $u['u7'],
                    8 => $u['u8'],
                    9 => $u['u9'],
                    10 => $u['u10'],
                    11 => $u['u11'],
                ),
                "villageId" => $v['wid'],
                "villageIdLocation" => $v['wid'],
                "villageIdSupply" => $v['wid'],
                "villageName" => $v['vname'],
                "villageNameLocation" => ""
            )
        );
        if ($head == false) {
            return $return['data']['units'];
        } else {
            return $return;
        }
    }

    public function checkTarget($target, $village, $type, $hero = false, $redeployHero = false, $short_time = false) {
        global $engine;
        $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($village))->fetch();
        $p = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?;", array($v['owner']))->fetch();

        $dist = $engine->world->getDistance($village, $target);
        $dataTarget = $engine->world->getMapDetail($target);
        $dataTargetPlayer = $engine->account->getByVillage($target);
        $dataVillage = $engine->world->getMapDetail($village);

        $hero = $engine->hero->get($v['owner'], false);

        $duration = array(
            1 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 1, 'speed') * $engine->server->speed_unit) * 3600,
            101 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 1, 'speed') * $engine->server->speed_unit) * 3600,
            2 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 2, 'speed') * $engine->server->speed_unit) * 3600,
            102 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 2, 'speed') * $engine->server->speed_unit) * 3600,
            3 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 3, 'speed') * $engine->server->speed_unit) * 3600,
            103 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 3, 'speed') * $engine->server->speed_unit) * 3600,
            4 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 4, 'speed') * $engine->server->speed_unit) * 3600,
            104 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 4, 'speed') * $engine->server->speed_unit) * 3600,
            5 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 5, 'speed') * $engine->server->speed_unit) * 3600,
            105 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 5, 'speed') * $engine->server->speed_unit) * 3600,
            6 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 6, 'speed') * $engine->server->speed_unit) * 3600,
            106 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 6, 'speed') * $engine->server->speed_unit) * 3600,
            7 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 7, 'speed') * $engine->server->speed_unit) * 3600,
            107 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 7, 'speed') * $engine->server->speed_unit) * 3600,
            8 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 8, 'speed') * $engine->server->speed_unit) * 3600,
            108 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 8, 'speed') * $engine->server->speed_unit) * 3600,
            9 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 9, 'speed') * $engine->server->speed_unit) * 3600,
            109 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 9, 'speed') * $engine->server->speed_unit) * 3600,
            10 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 10, 'speed') * $engine->server->speed_unit) * 3600,
            110 => $dist / (UnitData::get(($p['tribe'] - 1) * 10 + 10, 'speed') * $engine->server->speed_unit) * 3600,
            11 => $dist / ($hero['speed'] * $engine->server->speed_unit) * 3600,
            111 => $dist / ($hero['speed'] * $engine->server->speed_unit) * 3600,
        );

        if ($type == 10) {
            $dataTarget['isOasis'] = 0;
            $dataTarget['village'] = null;
            $dataTarget['tribe'] = null;
            $dataTarget['oasisType'] = null;
            $dataTargetPlayer['uid'] = null;
            $dataTargetPlayer['username'] = null;
        }

        $xytarget = $engine->world->id2xy($target);

        if ($_SESSION[$engine->server->prefix . 'tutorial'] >= 2) {
            $dist = 2;
            $xytarget = [0, 0];
            $dataTarget['isOasis'] = false;
            $dataTarget['village'] = 'Robber hideout';
            $dataTarget['tribe'] = '1';
            $dataTarget['oasisType'] = 0;
            $dataTargetPlayer['uid'] = '-1';
            $dataTargetPlayer['username'] = 'Robber';
            $duration = [
                1 => 3,
                101 => 3,
                2 => 3,
                102 => 3,
                3 => 3,
                103 => 3,
                4 => 3,
                104 => 3,
                5 => 3,
                105 => 3,
                6 => 3,
                106 => 3,
                7 => 3,
                107 => 3,
                8 => 3,
                108 => 3,
                9 => 3,
                109 => 3,
                10 => 3,
                110 => 3,
                11 => 3,
                111 => 3,
            ];
        }

        $r = array(
            'destPlayerId' => ($dataTarget['isOasis']) ? 0 : $dataTargetPlayer['uid'],
            'destPlayerName' => ($dataTarget['isOasis']) ? '' : $dataTargetPlayer['username'],
            'distance' => $dist,
            'durations' => $duration,
            'isGovernorNPCVillage' => false,
            'isOasis' => ($dataTarget['isOasis']) ? $dataTarget['oasisType'] : false,
            'isRobberVillage' => false,
            'isWorldWonderVillage' => false,
            'ownVillage' => false,
            'srcPlayerId' => $p['uid'],
            'srcPlayerName' => $p['username'],
            'srcVillageId' => $v['wid'],
            'srcVillageName' => $v['vname'],
            'srcVillageTribe' => $p['tribe'],
            'srcVillageType' => "1",
            'villageId' => (string) $target,
            'villageName' => ($dataTarget['isOasis']) ? "Oasis (" . $xytarget[0] . "|" . $xytarget[1] . ")" : $dataTarget['village'],
            'villageTribe' => ($dataTarget['isOasis']) ? 4 : $dataTarget['tribe'],
            'villageType' => ($dataTarget['isOasis']) ? $dataTarget['oasisType'] : '0',
            'warning' => array(),
        );

        if ($type == 10) {
            $ncp = round($engine->account->getByVillage($village, 'cp'));
            $num_village = count($engine->village->getAll('own'));
            $usecp = (new CP)->get($num_village + 1);
            if ($ncp < $usecp) {
                $r = [
                    "errors" => [
                        [
                            "message" => "NotEnoughCulturePoints",
                            "params" => []
                        ]
                    ]
                ];
            }
        }
        return $r;
    }

    private function buildTrainData($wid, $type) {
        global $engine;
        if (in_array($type, $this->barrack)) {
            $btype = 19;
        } elseif (in_array($type, $this->stable)) {
            $btype = 20;
        } elseif (in_array($type, $this->workshop)) {
            $btype = 21;
        } elseif (in_array($type, $this->residence_palase)) {
            $residence = $engine->building->getTypeLevel($wid, 25);
            $palase = $engine->building->getTypeLevel($wid, 26);
            if ($residence > 0) {
                $btype = 25;
            } elseif ($palase > 0) {
                $btype = 26;
            }
        }
        $t = $engine->tech->getTech($wid, $type);
        return array(
            "costs" => array(1 => UnitData::get($type, 'wood'), 2 => UnitData::get($type, 'clay'), 3 => UnitData::get($type, 'iron'), 4 => UnitData::get($type, 'crop')),
            "time" => (UnitData::get($type, 'time') * ($engine->building->BuildingEffect($btype, $engine->building->getTypeLevel($wid, $btype)) / 100)) / $engine->server->speed_world,
            "crop" => UnitData::get($type, 'pop'),
            "currentStrength" => array(
                "attack" => UnitData::get($type, 'atk'),
                "defence" => UnitData::get($type, 'di'),
                "defenceCavalry" => UnitData::get($type, 'dc')
            )
        );
    }

    public function getTrainList($wid, $location) {
        global $engine;
        $type = $engine->building->getBuilding(array('wid' => $wid, 'location' => $location))['data']['buildingType'];
        $tribe = $engine->account->getByVillage($wid, 'tribe');

        $r = array(
            "buildable" => array(),
            "notResearched" => array()
        );

        $t = $engine->tech->getTech($wid);
        if ($type == "19") {
            $r['buildable'][1 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 1 + (($tribe - 1) * 10));
            if ($t['t2'] >= 0) {
                $r['buildable'][2 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 2 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][2 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 2 + (($tribe - 1) * 10));
            }
            if ($t['t3'] >= 0) {
                $r['buildable'][3 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 3 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][3 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 3 + (($tribe - 1) * 10));
            }
        } elseif ($type == "20") {
            if ($t['t4'] >= 0) {
                $r['buildable'][4 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 4 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][4 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 4 + (($tribe - 1) * 10));
            }
            if ($t['t5'] >= 0) {
                $r['buildable'][5 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 5 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][5 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 5 + (($tribe - 1) * 10));
            }
            if ($t['t6'] >= 0) {
                $r['buildable'][6 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 6 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][6 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 6 + (($tribe - 1) * 10));
            }
        } elseif ($type == "21") {
            if ($t['t7'] >= 0) {
                $r['buildable'][7 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 7 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][7 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 7 + (($tribe - 1) * 10));
            }if ($t['t8'] >= 0) {
                $r['buildable'][8 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 8 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][8 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 8 + (($tribe - 1) * 10));
            }
        } elseif ($type == "25" || $type == "26") {
            if ($t['t9'] >= 0) {
                $r['buildable'][9 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 9 + (($tribe - 1) * 10));
            } else {
                $r['notResearched'][9 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 9 + (($tribe - 1) * 10));
            }
            $r['buildable'][10 + (($tribe - 1) * 10)] = $this->buildTrainData($wid, 10 + (($tribe - 1) * 10));
        }
        return $r;
    }

    public function getVillageUnit($vref = null) {
        global $engine;
        if ($vref === null) {
            $return = array();
            for ($i = 0; $i < count($engine->village->data); $i += 1) {
                $return[$i] = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `wid`=?", array($engine->village->data[$i]['wid']))->fetch();
                if ($return[$i] == false) {
                    $return[$i] = array();
                }
            }
        } else {
            $return = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `wid`=?", array($vref))->fetch();
        }
        return $return;
    }

    public function getStay($wid, $head = true) {
        global $engine;

        $r = array();
        $stays = query("SELECT * FROM `" . $engine->server->prefix . "troop_stay` WHERE `wid`=?;", array($wid))->fetchAll();

        foreach ($stays as $stay) {
            $u = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `id`=?;", array($stay['unit']))->fetch();
            $v = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($u['wid']))->fetch();
            $p = $engine->account->getById($stay['owner']);
            $w = $engine->world->getMapDetail($u['wid']);

            if (isset($w['isOasis'])) {
                if ($w['isOasis'] == true) {
                    $vid = $u['wid'];
                    $vname = "Oasis (" . $engine->world->id2xy($vid)[0] . "|" . $engine->world->id2xy($vid)[1] . ")";
                } else {
                    $vid = $v['wid'];
                    $vname = $v['vname'];
                }
                if ($stay['owner'] == 4) {
                    $uid = 0;
                    $username = null;
                } else {
                    $uid = $p['uid'];
                    $username = $p['username'];
                }
            } else {
                $vid = $v['wid'];
                $vname = $v['vname'];
                $uid = $p['uid'];
                $username = $p['username'];
            }

            $vl = query("SELECT * FROM `" . $engine->server->prefix . "village` WHERE `wid`=?;", array($stay['wid']))->fetch();
            $pl = $engine->account->getByVillage($stay['wid']);

            $supply = 0;
            for ($i = 1; $i <= 10; $i++) {
                $supply += $u['u' . $i] * UnitData::get($i + (($p['tribe'] - 1) * 10), 'pop');
            }
            $status = ($wid == $u['wid']) ? "home" : "support";
            $troop = [
                "name" => "Troops:" . $u['id'],
                "data" => array(
                    "troopId" => $u['id'],
                    "tribeId" => $p['tribe'],
                    "capacity" => 715,
                    "filter" => "",
                    "playerId" => $uid,
                    "playerName" => $username,
                    "villageId" => $vid,
                    "villageName" => $vname,
                    "villageIdSupply" => $stay['wid'],
                    "playerIdLocation" => $pl['uid'],
                    "playerNameLocation" => $pl['username'],
                    "villageIdLocation" => $stay['wid'],
                    "villageNameLocation" => $vl['vname'],
                    "status" => $status,
                    "supplyTroops" => $supply,
                    "units" => array(
                        1 => $u['u1'],
                        2 => $u['u2'],
                        3 => $u['u3'],
                        4 => $u['u4'],
                        5 => $u['u5'],
                        6 => $u['u6'],
                        7 => $u['u7'],
                        8 => $u['u8'],
                        9 => $u['u9'],
                        10 => $u['u10'],
                        11 => $u['u11'],
                    ),
                )
            ];
            array_push($r, $head ? $troop : $troop['data']);
        }
        $r = array(
            "name" => "Collection:Troops:stationary:" . $wid,
            "data" => array(
                "operation" => 1,
                "cache" => $r,
            )
        );
        return $head ? $r : $r['data']['cache'];
    }

    public function createUnit($owner, $units) {
        global $engine;
        for ($i = 1; $i <= 11; $i++) {
            !isset($units[$i]) ? $units[$i] = 0 : '';
        }
        query("INSERT INTO `" . $engine->server->prefix . "units` (`wid`,`u1`,`u2`,`u3`,`u4`,`u5`,`u6`,`u7`,`u8`,`u9`,`u10`,`u11`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", array($owner, $units[1], $units[2], $units[3], $units[4], $units[5], $units[6], $units[7], $units[8], $units[9], $units[10], $units[11]));
        return $engine->sql->lastInsertId();
    }

    public function addStay($village, $owner, $unit) {
        global $engine;
        query("INSERT INTO `" . $engine->server->prefix . "troop_stay` (`wid`,`owner`,`unit`) VALUES (?,?,?)", array($village, $owner, $unit));
    }

    public function addUnit($village, $type, $amount = 0, $owner = null) {
        global $engine;
        ($owner === null) ? $owner = $engine->account->getByVillage($village, 'uid') : $owner = $engine->account->getByVillage($village, 'uid');

        $sq = query("SELECT * FROM `" . $engine->server->prefix . "troop_stay` WHERE `wid`=? AND `owner`=?;", array($village, $owner));
        if ($sq->rowCount() == 0) {
            $tid = $this->createUnit($village, []);
            $this->addStay($village, $owner, $tid);
        } else {
            $tid = $sq->fetch()['unit'];
        }
        query("UPDATE `" . $engine->server->prefix . "units` SET `u" . $type . "`=`u" . $type . "`+? WHERE `id`=?;", array($amount, $tid));
    }

    public function setUnit($village, $type, $amount = 0, $owner = null) {
        global $engine;
        ($owner === null) ? $owner = $engine->account->getByVillage($village, 'uid') : $owner = $engine->account->getByVillage($village, 'uid');
        $sq = query("SELECT * FROM `" . $engine->server->prefix . "troop_stay` WHERE `wid`=? AND `owner`=?;", array($village, $owner));
        if ($sq->rowCount() == 0) {
            $tid = $this->createUnit($village, []);
            $this->addStay($village, $owner, $tid);
        } else {
            $tid = $sq->fetch()['unit'];
        }
        query("UPDATE `" . $engine->server->prefix . "units` SET `u" . $type . "`=? WHERE `id`=?;", array($amount, $tid));
    }

    public function removeUnit($village, $type, $amount = 'all', $owner = null) {
        global $engine;
        ($owner === null) ? $owner = $engine->account->getByVillage($village, 'uid') : $owner = $engine->account->getByVillage($village, 'uid');
        $stay = query("SELECT * FROM `" . $engine->server->prefix . "troop_stay` WHERE `wid`=? AND `owner`=?;", array($village, $owner))->fetch();
        $q = query("SELECT * FROM `" . $engine->server->prefix . "units` WHERE `id`=?;", array($stay['unit']))->rowCount();
        if ($q != 0) {
            $tid = $stay['unit'];
            query("UPDATE `" . $engine->server->prefix . "units` SET `u" . $type . "`=`u" . $type . "`-? WHERE `id`=?;", array($amount, $tid));
        }
    }

    public function calculate_power($data = []) {
        global $engine;

        $attacker = [
            'tribe' => $data['attackerTribe'],
            'unit' => $data['attackerUnits'],
            'research' => $data['attackerResearch'],
        ];
        $defender = [];

        for ($i = 0; $i < count($data['defenderUnits']); $i++) {
            array_push($defender, [
                'tribe' => $data['defenderTribe'][$i],
                'unit' => $data['defenderUnits'][$i],
                'research' => isset($data['defenderResearch'][$i]) ? $data['defenderResearch'][$i] : [],
            ]);
        }

        $battleResult = $engine->battle->calculateBattle(3, $attacker, $defender);
        $modules = [];

        array_push($modules, [
            "name" => "troops/attacker",
            "body" => $battleResult['attacker'],
        ]);
        foreach ($battleResult['defender'] as $k => $brd) {
            array_push($modules, [
                "name" => $k == 0 ? "troops/defender" : "troops/support",
                "body" => $brd,
            ]);
        }
        foreach ($battleResult['sum'] as $brs) {
            array_push($modules, [
                "name" => "troops/tribeSum",
                "body" => $brs,
            ]);
        }

        $r = [
            "attackType" => 0,
            "bounty" => null,
            "capacity" => 500,
            "destId" => 0,
            "destKingdomId" => null,
            "destKingdomTag" => "",
            "destName" => "",
            "destPlayerId" => -1,
            "destPlayerName" => "Robber",
            "destTribeId" => 1,
            "destType" => 0,
            "destX" => null,
            "destY" => null,
            "modules" => $modules,
            "otherKingdomId" => null,
            "ownRole" => "defender",
            "playerId" => 0,
            "sourceId" => 0,
            "sourceKingdomId" => null,
            "sourceKingdomTag" => "",
            "sourceName" => "",
            "sourcePlayerId" => 0,
            "sourcePlayerName" => "attacker",
            "sourceTribeId" => 1,
            "statistics" => $battleResult['data'],
            "stolenGoods" => null,
            "supply" => 0,
            "time" => time(),
            "treasures" => null,
            "tributeBounty" => null,
            "troopId" => -1,
            "victoryPoints" => null,
        ];

        return $r;
    }

    public function realBattle($data) {
        global $engine;

        $pa = $engine->account->getByVillage($data['from']);
        $va = $engine->village->get($data['from'], false);
        $attacker = [
            'wid' => $data['from'],
            'player' => [
                'id' => $pa['uid'],
                'name' => $pa['username'],
            ],
            'village' => [
                'id' => '',
                'name' => '',
                'pop' => '',
            ],
            'tribe' => $pa['tribe'],
            'unit' => $this->getUnit($data['unit'], false)
        ];
        $defender = [];

        $troopsStay = $this->getStay($data['to'], false);
        $pd = $engine->account->getByVillage($data['to']);
        $vd = $engine->village->get($data['to'], false);
        foreach ($troopsStay as $troop) {
            array_push($defender, [
                'wid' => $data['to'],
                'player' => [
                    'id' => $troop['playerId'],
                    'name' => $troop['playerName'],
                ],
                'village' => [
                    'id' => $troop['villageId'],
                    'name' => $troop['villageName'],
                    'pop' => '',
                ],
                'tribe' => $troop['tribeId'],
                'tribeId' => $troop['tribeId'],
                'unit' => $troop['units'],
            ]);
        }
        if ($pa['tutorial'] == 3) {
            array_push($defender, [
                'wid' => '536920065',
                'player' => [
                    'id' => '-1',
                    'name' => 'Robber',
                ],
                'village' => [
                    'id' => '536920065',
                    'name' => 'Robber hideout',
                    'pop' => '',
                ],
                'tribe' => '1',
                'tribeId' => '1',
                'unit' => [1 => 5],
            ]);
        }

        var_dump($defender);

        $battleResult = $engine->battle->calculateBattle(3, $attacker, $defender);

        $source = [
            'troopId' => $data['unit'],
            'tribeId' => $pa['tribe'],
            'playerId' => $pa['uid'],
            'playerName' => $pa['username'],
            'villageId' => $va['villageId'],
            'villageName' => $va['name'],
        ];
        $target = [
            'tribeId' => $pd['tribe'],
            'playerId' => $pd['uid'],
            'playerName' => $pd['username'],
            'villageId' => $vd['villageId'],
            'villageName' => $vd['name'],
            'coordinates' => [
                'x' => $vd['coordinates']['x'],
                'y' => $vd['coordinates']['y'],
            ],
        ];
        $detail = [
            'capacity' => 0,
            'bounty' => [
                'wood' => 0,
                'clay' => 0,
                'iron' => 0,
                'crop' => 0,
            ],
            'final' => $battleResult['final']
        ];
        $modules = ['attacker' => [], 'defender' => [], 'support' => [], 'sum' => []];

        $modules['attacker'] = [
            "name" => "troops/attacker",
            "body" => $battleResult['attacker'],
        ];
        foreach ($battleResult['defender'] as $k => $brd) {
            if ($k == 0) {
                $modules['defender'] = [
                    "name" => "troops/defender",
                    "body" => $brd,
                ];
            } else {
                array_push($modules['support'], [
                    "name" => "troops/support",
                    "body" => $brd,
                ]);
            }
        }
        foreach ($battleResult['sum'] as $brs) {
            array_push($modules['sum'], [
                "name" => "troops/tribeSum",
                "body" => $brs,
            ]);
        }
        if ($data['owner'] > 100) {
            $id = $engine->report->add(4, $pa['uid'], $source, $target, $detail, $modules);
        }

        if ($pa['tutorial'] == 3) {
            $engine->account->edit('tutorial', 4, $pa['uid']);
            $engine->auto->emitCache($pa['uid'], $engine->quest->get($pa['uid']));
        } else {
            if ($data['owner'] > 100) {
                $engine->notification->add($pa['uid'], 1, $id, 'movement_attack_medium_flat_positive');
            }
        }
    }

}
